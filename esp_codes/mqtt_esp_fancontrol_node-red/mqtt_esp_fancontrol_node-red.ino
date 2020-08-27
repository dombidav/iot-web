
#include <ESP8266WiFi.h>
#include <PubSubClient.h>

IPAddress deviceIp(192, 168, 0, 43);
byte deviceMac[] = { 0xAB, 0xCD, 0xFE, 0xFE, 0xFE, 0xFE };
char* deviceId  = "fan01"; // Name of the sensor
int updateInterval = 5000;
long statusMsg = 0;

#define wifi_ssid "Labor Eger24"
#define wifi_password "LaborEger2018"
#define mqtt_user "labor"
#define mqtt_password "labor"
#define fan_topic1 "fan/switch"
#define fan_topic2 "fan/slider"
#define status_topic "status/fan01"

IPAddress mqttServer(192, 168, 0, 150);
int mqttPort = 1883;
WiFiClient espClient;
PubSubClient client(espClient);

int signalPin=2;

void setup_wifi() {
  delay(10);
  // We start by connecting to a WiFi network
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(wifi_ssid);
  WiFi.begin(wifi_ssid, wifi_password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
}

void reconnect() {
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    // Attempt to connect
    // If you do not want to use a username and password, change next line to
    // if (client.connect("ESP8266Client")) {
    if (client.connect(deviceId, mqtt_user, mqtt_password)) {
      Serial.println("connected");
      client.subscribe(fan_topic1);
      client.subscribe(fan_topic2);
      
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      // Wait 5 seconds before retrying
      delay(updateInterval);
    }
  }
}

void callback(char* topic, byte* message, unsigned int length) {
  Serial.print("Message arrived on topic: ");
  Serial.print(topic);
  Serial.print(". Message: ");
  String messageTemp;
  
  for (int i = 0; i < length; i++) {
    Serial.print((char)message[i]);
    messageTemp += (char)message[i];
  }
  Serial.println();

  // Feel free to add more if statements to control more GPIOs with MQTT

  // If a message is received on the topic esp32/output, you check if the message is either "on" or "off". 
  // Changes the output state according to the message
  if (String(topic) == fan_topic1) {
    Serial.print("Changing output to ");
    if(messageTemp == "on"){
      Serial.println("Fan on");
      //digitalWrite(signalPin,HIGH);
    }
    else if(messageTemp == "off"){
      Serial.println("Fan off");
      //digitalWrite(signalPin, LOW);
      
      
    }
  }
  else if(String(topic)==fan_topic2 ){
    if(messageTemp == "0"){
      Serial.println("Fan off");
      analogWrite(signalPin,0);
    }
    
    if(messageTemp == "1"){
      Serial.println("Fan on stage 1");
      analogWrite(signalPin,51);
    }
    else if(messageTemp == "2"){
      Serial.println("Fan on stage 2");
      analogWrite(signalPin,102);
    }
    else if(messageTemp == "3"){
       Serial.println("Fan on stage 3");
      analogWrite(signalPin,153);
    }
    else if(messageTemp=="4"){
     Serial.println("Fan on stage 4");
      analogWrite(signalPin,204);
    }
    else if(messageTemp=="5"){
     Serial.println("Fan on Max");
      analogWrite(signalPin,255);
    }
  }
}

void setup() {
  Serial.begin(115200);
  setup_wifi();
  pinMode(signalPin,OUTPUT);
  client.setServer(mqttServer,mqttPort);
  client.setCallback(callback);
}

void loop() {
  if(!client.connected())
  {
    reconnect();
  }
  client.loop();
  long now = millis();
  if (now - statusMsg > 30000) {
  statusMsg=now;
  client.publish(status_topic,"online", true);
  }
  
  
}
