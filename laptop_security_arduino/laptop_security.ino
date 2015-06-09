
#include <SPI.h>
#include <Ethernet.h>
#include <MFRC522.h>

// Enter a MAC address and IP address for your controller below.
// The IP address will be dependent on your local network:
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
IPAddress ip(192,168,0,5);
// Initialize the Ethernet server library
// with the IP address and port you want to use 
// (port 80 is default for HTTP):
EthernetServer server(80);
//definition of mfrc522 Slave and Reset pins
// Create MFRC522 instance
#define SS_PIN 8
#define RST_PIN 9
MFRC522 mfrc522(SS_PIN, RST_PIN);
//Definition of variables to store the Card ID	
byte readCard[5];
String card_ID = "";

void setup() 
{
  Serial.begin(9600); // Open serial communications
  Ethernet.begin(mac, ip); // start the Ethernet connection and the server:
  Serial.print("Server is at ");
  Serial.println(Ethernet.localIP());
  SPI.begin();		// Init SPI bus
  mfrc522.PCD_Init();	// Init MFRC522 card
}

void loop() 
{
  // Look for new cards
  Serial.println("Looking for new card...");
  if ( ! mfrc522.PICC_IsNewCardPresent()){
    return;//go to start of loop if there is no card present
  }
  if( mfrc522.PICC_ReadCardSerial()){// we ASSUME that a card is selected
    Serial.println("Found card!");
    Serial.print("Card ID is: ");// print the ID to serial
    for (int i = 0; i < mfrc522.uid.size; i++)
    {  
      // for size of uid.size write uid.uidByte to readCard
      readCard[i] = mfrc522.uid.uidByte[i];
      Serial.print(readCard[i], HEX);
      card_ID += String(readCard[i], HEX);// save the ID to card_ID in HEX string format
    }
    Serial.println("");
    String data = "cardID=" + card_ID;// parse for sending to browser
    EthernetClient client = server.available();
    if (client) {
    Serial.println("new client");
    // an http request ends with a blank line
    boolean currentLineIsBlank = true;
    while (client.connected()) {
      if (client.available()) {
        char c = client.read();
        Serial.write(c);
        // if you've gotten to the end of the line (received a newline
        // character) and the line is blank, the http request has ended,
        // so you can send a reply
        if (c == '\n' && currentLineIsBlank) {
          // send a standard http response header
          client.println("HTTP/1.1 200 OK");
          client.println("Content-Type: text/html");
          client.println("Connection: close");  // the connection will be closed after completion of the response
          client.println("Refresh: 5");  // refresh the page automatically every 5 sec
          client.println();
          client.println("<!DOCTYPE HTML>");
          client.println("<html>");
          client.println("<meta http-equiv='refresh' content='0; url=http://localhost/laptop_security/index.php?");
          client.print(data);
          client.print("'>");
          client.println("</html>");
          break;
        }
        if (c == '\n') {
          // you're starting a new line
          currentLineIsBlank = true;
        }
        else if (c != '\r') {
          // you've gotten a character on the current line
          currentLineIsBlank = false;
        }
      }
    }
    // give the web browser time to receive the data
    delay(1);
    // close the connection:
    client.stop();
    Serial.println("client disconnected");
    Serial.println(".................................................................");
  }
  //clear variables
  card_ID="";
  data="";
  delay(1000);
  }
}
