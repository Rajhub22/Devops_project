-- Create the 'aura_amour' database if it doesn't exist
CREATE DATABASE IF NOT EXISTS aura_amour;

-- Use the created database
USE aura_amour;

-- Create the 'users' table to store user information
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15),
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the 'events' table to store event details
CREATE TABLE IF NOT EXISTS events (
    event_id VARCHAR(255) PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL
);

-- Table to store budgeting data for events
CREATE TABLE IF NOT EXISTS budgeting (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE
);

-- Table to store To-Do list data for events
CREATE TABLE IF NOT EXISTS todo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id VARCHAR(255) NOT NULL,
    task TEXT NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE
);

-- Table to store materials needed for events
CREATE TABLE IF NOT EXISTS materials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id VARCHAR(255) NOT NULL,
    material TEXT NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE
);

-- Table to store contacts for events
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL
);

-- Table for Birthday Event (this can be used for specific event management)
CREATE TABLE IF NOT EXISTS BirthdayEvent (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255),
    amount DECIMAL(10, 2),
    todo_task TEXT,
    materials TEXT,
    contact_name VARCHAR(255),
    contact_phone VARCHAR(50)
);

-- Table for general budget data
CREATE TABLE IF NOT EXISTS budget (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL
);

-- Table for storing To-Do list tasks
CREATE TABLE IF NOT EXISTS todo_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task VARCHAR(255) NOT NULL
);

-- Festival Table --
CREATE TABLE festive_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    materials TEXT,
    todo_list TEXT, -- Use TEXT as a fallback for the to-do list
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--Aniversary--
CREATE TABLE Anniversary (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    todo TEXT NOT NULL,
    materials TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
--Organisational--
CREATE TABLE Organisation (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    event_description TEXT NOT NULL,
    materials TEXT NOT NULL,
    todo TEXT NOT NULL
);

-- Create the Budget table
CREATE TABLE Budget1 (
    budget_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    category VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (event_id) REFERENCES Organisation(event_id) ON DELETE CASCADE
);


-- Create table for school events
CREATE TABLE school_events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    event_description TEXT NOT NULL,
    materials TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table for school budgets
CREATE TABLE school_budgets (
    budget_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    category VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (event_id) REFERENCES school_events(event_id) ON DELETE CASCADE
);

-- Create table for school to-do list
CREATE TABLE school_todos (
    todo_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    task VARCHAR(255) NOT NULL,
    FOREIGN KEY (event_id) REFERENCES school_events(event_id) ON DELETE CASCADE
);


--Summit table--
CREATE TABLE summit_events (
    summit_event_id INT AUTO_INCREMENT PRIMARY KEY,
    summit_event_name VARCHAR(255) NOT NULL,
    summit_event_start_date DATE NOT NULL,
    summit_event_end_date DATE NOT NULL,
    summit_event_description TEXT NOT NULL,
    summit_materials VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table to store agenda details for each event
CREATE TABLE summit_agenda (
    summit_agenda_id INT AUTO_INCREMENT PRIMARY KEY,
    summit_event_id INT NOT NULL,
    summit_session_title VARCHAR(255) NOT NULL,
    summit_session_start_time TIME NOT NULL,
    summit_session_end_time TIME NOT NULL,
    summit_session_speaker VARCHAR(255) NOT NULL,
    FOREIGN KEY (summit_event_id) REFERENCES summit_events(summit_event_id) ON DELETE CASCADE
);

-- Table to store budget details for each event
CREATE TABLE summit_budget (
    summit_budget_id INT AUTO_INCREMENT PRIMARY KEY,
    summit_event_id INT NOT NULL,
    summit_category VARCHAR(255) NOT NULL,
    summit_amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (summit_event_id) REFERENCES summit_events(summit_event_id) ON DELETE CASCADE
);

-- Table to store to-do list items for each event
CREATE TABLE summit_todos (
    summit_todo_id INT AUTO_INCREMENT PRIMARY KEY,
    summit_event_id INT NOT NULL,
    summit_task TEXT NOT NULL,
    FOREIGN KEY (summit_event_id) REFERENCES summit_events(summit_event_id) ON DELETE CASCADE
);


--Meetings--
-- Table for storing meeting details
CREATE TABLE Ebefor_meetings (
    meeting_id INT AUTO_INCREMENT PRIMARY KEY,
    meeting_title VARCHAR(255) NOT NULL,
    meeting_datetime DATETIME NOT NULL,
    meeting_timezone VARCHAR(50) NOT NULL,
    meeting_description TEXT NOT NULL,
    meeting_type ENUM('In-person', 'Virtual') NOT NULL,
    priority_level ENUM('Low', 'Medium', 'High') NOT NULL,
    reminder_time DATETIME,
    reminder_method ENUM('Email', 'SMS', 'Push Notification'),
    recurring_meeting BOOLEAN DEFAULT FALSE,
    recurrence_frequency ENUM('Daily', 'Weekly', 'Monthly'),
    recurrence_end_date DATE
);

-- Table for storing agenda items associated with meetings
CREATE TABLE Ebefor_agenda_items (
    agenda_id INT AUTO_INCREMENT PRIMARY KEY,
    meeting_id INT,
    agenda_item VARCHAR(255) NOT NULL,
    agenda_time DATETIME NOT NULL,
    FOREIGN KEY (meeting_id) REFERENCES Ebefor_meetings(meeting_id) ON DELETE CASCADE
);

-- Table for storing attendees for each meeting
CREATE TABLE Ebefor_attendees (
    attendee_id INT AUTO_INCREMENT PRIMARY KEY,
    meeting_id INT,
    attendee_name VARCHAR(255) NOT NULL,
    FOREIGN KEY (meeting_id) REFERENCES Ebefor_meetings(meeting_id) ON DELETE CASCADE
);

-- Table for storing materials for each meeting
CREATE TABLE Ebefor_materials (
    material_id INT AUTO_INCREMENT PRIMARY KEY,
    meeting_id INT,
    material_name VARCHAR(255) NOT NULL,
    FOREIGN KEY (meeting_id) REFERENCES Ebefor_meetings(meeting_id) ON DELETE CASCADE
);

-- Table for storing meeting attachments
CREATE TABLE Ebefor_attachments (
    attachment_id INT AUTO_INCREMENT PRIMARY KEY,
    meeting_id INT,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (meeting_id) REFERENCES Ebefor_meetings(meeting_id) ON DELETE CASCADE
);

-- Table for storing reminder settings
CREATE TABLE Ebefor_reminders (
    reminder_id INT AUTO_INCREMENT PRIMARY KEY,
    meeting_id INT,
    reminder_time DATETIME,
    reminder_method ENUM('Email', 'SMS', 'Push Notification'),
    FOREIGN KEY (meeting_id) REFERENCES Ebefor_meetings(meeting_id) ON DELETE CASCADE
);

-- Table for storing recurring meeting information
CREATE TABLE Ebefor_recurring_meetings (
    recurrence_id INT AUTO_INCREMENT PRIMARY KEY,
    meeting_id INT,
    recurrence_frequency ENUM('Daily', 'Weekly', 'Monthly'),
    recurrence_end_date DATE,
    FOREIGN KEY (meeting_id) REFERENCES Ebefor_meetings(meeting_id) ON DELETE CASCADE
);
CREATE TABLE Ebefor_reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    review TEXT NOT NULL,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
