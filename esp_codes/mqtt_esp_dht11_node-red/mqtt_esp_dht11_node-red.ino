#include <ESP8266WiFi.h>
#include <PubSubClient.h>
#include <Adafruit_Sensor.h>
#include <DHT.h>


int humidityData=0;
int temperatureData=0;
long lastMsg = 0;
float diff = 1.0;
String publishTemp="";
String publishHum="";
String publishStatus="";

#define DHTPIN 2
#define DHTTYPE    DHT11  
DHT dht(DHTPIN, DHTTYPE);

IPAddress deviceIp(192, 168, 0, 43);
byte deviceMac[] = { 0xAB, 0xCD, 0xFE, 0xFE, 0xFE, 0xFE };
String chipID=String(ESP.getChipId());
const char* deviceId  = chipID.c_str(); // Name of the sensor
int updateInterval = 5000; // Interval in milliseconds
#define humidity_topic "sensor/humidity"
#define wifi_ssid "Labor Eger24"
#define wifi_password "LaborEger2018"
#define temperature_topic "sensor/temperature"
#define status_topic "status/device01"
#define mqtt_user "labor"
#define mqtt_password "labor"
IPAddress mqttServer(192, 168, 0, 152);
int mqttPort = 1883;
WiFiClient espClient;
PubSubClient client(espClient);



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
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      // Wait 5 seconds before retrying
      delay(updateInterval);
    }
  }
}



void setup() {
  Serial.begin(115200);
  dht.begin();
  delay(2000);
  setup_wifi();
  client.setServer(mqttServer, mqttPort);

}

bool checkBound(float newValue, float prevValue, float maxDiff) {
  return !isnan(newValue) &&
         (newValue < prevValue - maxDiff || newValue > prevValue + maxDiff);
}


void loop() {
  
 if (!client.connected()) {
    reconnect();
  }
  client.loop();
long now = millis();
if (now - lastMsg > 3000) {
 lastMsg = now;
 publishStatus=String("{")+"Status"+":"+'"'+"online"+'"'+","+"device_id"+":"+'"'+deviceId+'"'+"}";
 client.publish(status_topic,publishStatus.c_str(), true);
 
 float newTemp = dht.readTemperature();
 float newHum = dht.readHumidity();

 
 if (checkBound(newTemp, temperatureData, diff)) {
      temperatureData = rint(newTemp);
      Serial.print("New temperature:");
      Serial.println(String(temperatureData).c_str());
      publishTemp=String("{")+"Temperature"+":"+'"'+String(temperatureData)+'"'+","+"device_id"+":"+'"'+deviceId+'"'+"}";
      client.publish(temperature_topic,publishTemp.c_str(),true);
      //delay(updateInterval);
    }
 if (checkBound(newHum, humidityData, diff)) {
      humidityData =rint(newHum);
      Serial.print("New humidity:");
      Serial.println(String(humidityData).c_str());
      publishHum=String("{")+"Humidity"+":"+'"'+String(humidityData)+'"'+","+"device_id"+":"+'"'+deviceId+'"'+"}";
      client.publish(humidity_topic, publishHum.c_str(), true);
      //delay(updateInterval);
    }



}
}
