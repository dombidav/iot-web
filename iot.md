# Project IoT

- [Project IoT](#project-iot)
  - [Resources](#resources)
    - [User](#user)
    - [Worker](#worker)
    - [Worker group](#worker-group)
    - [Lock](#lock)
    - [Device](#device)
  - [Endpoints](#endpoints)
    - [Resource (CRUD):](#resource-crud)
    - [Plugin Controllers:](#plugin-controllers)

Plugins
- Access Control System (ACS)
- Thermometers
- Cameras
- Fans
- Heating Control


## Resources

### User

- ID
- Name
- Email
- Password

### Worker 

(*Belongs to many* Worker group)
- ID
- Name
- RFID

### Worker group 

(*Has many* Worker)
(*Has many* Lock)
- ID
- Name

### Lock

(*Belongs to many*  Worker group)
- ID
- Name

### Log
- ID
- Person
- Subject
- Description
- Timestamp

*(Note: Log records are )*

### Device

- ID
- Name
- ...


## Endpoints

### Resource (CRUD):
- Worker
- Worker group
- Lock
- Device
- Log

### Plugin Controllers:
- POST: AuthenticateWorker
  - Parameter: Worker.RFID, Device.ID
  - Returns: OK / FAIL
- GET: ThermometerData
  - Parameter: Device.ID, User.ID
  - Returns: (float) Temperature
- GET: FanData
  - Parameter: Device.ID, User.ID
  - Returns: (float) RPM
- PUT: FanData
  - Parameter: Device.ID, User.ID, (float) Rotation
  - Returns: -
- GET: Heating data
  - Parameter: Device.ID, User.ID
  - Returns: (float) RPM
- PUT: Heating data
  - Parameter: Device.ID, User.ID, (float) Rotation
  - Returns: -
- GET: Camera stream
  - Parameter: Device.ID, User.ID
  - Returns: Stream
- (Validate Connection)
