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

(`M-M` Worker group)
- ID
- Name
- RFID

### Worker group 

(`M-M` Worker)
(`M-M` Lock)
- ID
- Name

### Lock

(`M-M` Worker group)
- ID
- Name

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

### Plugin Controllers:
- POST: Authenticate Worker
  - Parameter: Worker.RFID, Device.ID
  - Returns: OK / FAIL
- GET: Thermometer Data
  - Parameter: Device.ID, User.ID
  - Returns: (float) Temperature
- GET: Fan data
  - Parameter: Device.ID, User.ID
  - Returns: (float) RPM
- PUT: Fan data
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