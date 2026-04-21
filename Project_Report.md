# Mini Project Report: Bus Reservation Management System

## 1. Title of the Project, Abstract, Introduction

### Title
**BusGo: A Modern Bus Reservation Management System**

### Abstract
The Bus Reservation Management System is a web-based application designed to automate and streamline the process of booking bus tickets online. It eliminates the traditional, manual processes of reserving seats by providing a user-friendly interface where passengers can search for buses, check real-time seat availability, and book or cancel tickets seamlessly. The system uses a responsive frontend (HTML, CSS, JS) and is designed to integrate with a relational database (MySQL) to persistently store user, booking, and bus schedule data. The objective is to provide an efficient execution of the Software Development Life Cycle (SDLC) for a robust travel solution.

### Introduction
The travel and transportation industry heavily relies on speed, convenience, and accurate information. Traditionally, passengers had to physically visit bus terminals or agents to book their journeys, which was time-consuming and inefficient. "BusGo," our Bus Reservation Management System, is built to bridge this gap by bringing the bus terminal to the passenger's screen. By adhering to the principles of Software Engineering, the project ensures modularity, high performance, and security.

---

## 2. Software Requirement Specification (SRS)

### Functional Requirements
1. **User Module:**
   - User registration and login functionality.
   - Profile management.
   - Search for buses based on source, destination, and date.
   - View bus details, types (Sleeper, Semi-Sleeper, Volvo, Express), and seat layouts.
   - Book tickets and select seats.
   - View booking history and cancel tickets.
2. **Admin Module:**
   - Admin login.
   - Manage buses, routes, and schedules (Add/Update/Delete).
   - View all registered users and bookings.
   - Generate passenger and revenue reports.

### Non-Functional Requirements
1. **Performance:** The system should handle concurrent user booking requests without significant delays.
2. **Usability:** The interface must be responsive (mobile-friendly), intuitive, and easy to navigate for users of all technical backgrounds.
3. **Security:** User passwords must be securely hashed, and bookings should be protected against unauthorized access.
4. **Availability:** The system should have high uptime for 24/7 ticket booking operations.

### Hardware & Software Requirements
- **Frontend:** HTML5, CSS3, Vanilla JavaScript.
- **Backend Environment:** PHP / Node.js / Java (Conceptualized).
- **Database:** MySQL / MongoDB / Oracle.
- **Tools:** VS Code, Git, Browser Developer Tools.

---

## 3. Conceptual Design (ER Diagram & Relational Model)

### Entities and Relationships (ER Features)
1. **User (Passenger):** Interacts with bookings.
   - Attributes: `User_ID` (PK), `Name`, `Email`, `Phone_Number`, `Password`, `Address`.
2. **Bus:** Transport operating on given routes.
   - Attributes: `Bus_ID` (PK), `Bus_Name`, `Bus_Type`, `Total_Seats`.
3. **Route:** The journey path.
   - Attributes: `Route_ID` (PK), `Source_City`, `Destination_City`, `Distance`, `Estimated_Time`.
4. **Schedule:** Bus timings.
   - Attributes: `Schedule_ID` (PK), `Bus_ID` (FK), `Route_ID` (FK), `Departure_Time`, `Arrival_Time`, `Fare`.
5. **Booking:** Reserving a seat.
   - Attributes: `Booking_ID` (PK), `User_ID` (FK), `Schedule_ID` (FK), `Booking_Date`, `Journey_Date`, `Total_Amount`, `Seat_Numbers`, `Status` (Confirmed, Cancelled).

### Relational Model (3NF)
- `USERS (User_ID, Name, Email, Phone, Password)`
- `BUSES (Bus_ID, Bus_Name, Bus_Type, Total_Seats)`
- `ROUTES (Route_ID, Source, Destination)`
- `SCHEDULES (Schedule_ID, Bus_ID, Route_ID, Departure, Arrival, Fare)`
- `BOOKINGS (Booking_ID, User_ID, Schedule_ID, BookingDate, JourneyDate, Seats, Status)`

---

## 4. Graphical User Interface (GUI) & Source Code Structure

### GUI Features
- **Navbar:** Sticky navigation with logo, Home, Search, My Bookings, Admin, and Login buttons.
- **Hero Section:** Dynamic search form allowing One Way and Round Trip searches with date validation.
- **Features Grid:** Showcases the benefits of using BusGo (Instant Booking, Seat Selection, Secure Payments).
- **Bus Types & Trending Routes:** Visually appealing cards with glassmorphism effects displaying available fleet types and prices.
- **Responsive Design:** A mobile-friendly layout with a hamburger menu for smaller screens.

### Source Code Mapping
The project is structured logically into separate directories:
1. `index.html`: The main landing and search page.
2. `css/style.css`: Contains CSS variables, Flexbox/Grid layouts, animations, and responsive media queries.
3. `js/main.js`: Houses interactions like toggling trip types, responsive mobile menus, and dynamic content injection.

---

## 5. Testing Document

### Manual Testing
| Test Case ID | Feature Tested | Input Given | Expected Output | Actual Output | Result |
|--------------|----------------|-------------|-----------------|---------------|--------|
| TC-01 | Client-side Validation | Empty form submission | Alert / Prevent submission | Prevented submission | **Pass** |
| TC-02 | Date Validation | Past date as Journey Date | Input field restricts past dates | Restricted by `min` attr | **Pass** |
| TC-03 | City Swap Button | Source: Pune, Dest: Mumbai | Source: Mumbai, Dest: Pune | Swapped correctly | **Pass** |
| TC-04 | Responsive Navbar | Window resize < 768px | Hamburger menu appears | Menu appeared | **Pass** |
| TC-05 | Trip Type Toggle | Click 'Round Trip' | Return Date input appears | Input appeared | **Pass** |

### Automation Testing Scope
Automation frameworks (e.g., Selenium or Cypress) can be utilized to mock:
- End-to-end user flows (Login -> Search Bus -> Select Seat -> Checkout -> Generate Ticket).

---

## 6. Conclusion
The **Bus Reservation Management System (BusGo)** was successfully developed by adhering to the Software Development Life Cycle. It integrates a sleek, intuitive frontend design with a structured, relational backend architecture plan. By providing features such as real-time interactive search and responsive web layouts, it successfully addresses the core inconveniences of traditional ticketing systems. Future enhancements can include live GPS tracking, payment gateway integration, and predictive pricing algorithms. This mini-project effectively demonstrates the practical application of software engineering principles, database design, and modern web development technologies.
