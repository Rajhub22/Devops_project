<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $meeting_title = $_POST['meeting_title'];
    $meeting_datetime = $_POST['meeting_datetime'];
    $meeting_timezone = $_POST['meeting_timezone'];
    $meeting_description = $_POST['meeting_description'];
    $meeting_type = $_POST['meeting_type'];
    $priority_level = $_POST['priority_level'];
    $reminder_time = $_POST['reminder_time'];
    $reminder_method = $_POST['reminder_method'];
    $recurring_meeting = isset($_POST['recurring_meeting']) ? 1 : 0;
    $recurrence_frequency = $_POST['recurrence_frequency'] ?? null;
    $recurrence_end_date = $_POST['recurrence_end_date'] ?? null;

    // Insert into meetings table
    $sql = "INSERT INTO Ebefor_meetings (meeting_title, meeting_datetime, meeting_timezone, meeting_description, meeting_type, priority_level, reminder_time, reminder_method, recurring_meeting, recurrence_frequency, recurrence_end_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssssss", $meeting_title, $meeting_datetime, $meeting_timezone, $meeting_description, $meeting_type, $priority_level, $reminder_time, $reminder_method, $recurring_meeting, $recurrence_frequency, $recurrence_end_date);
        $stmt->execute();
        $meeting_id = $stmt->insert_id;
        $stmt->close();
    }

    // Insert agenda items
    if (!empty($_POST['agenda_item'])) {
        $agenda_items = $_POST['agenda_item'];
        $agenda_times = $_POST['agenda_time'];
        for ($i = 0; $i < count($agenda_items); $i++) {
            if (!empty($agenda_items[$i])) {
                $sql = "INSERT INTO Ebefor_agenda_items (meeting_id, agenda_item, agenda_time)
                        VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $meeting_id, $agenda_items[$i], $agenda_times[$i]);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    // Insert attendees
    if (!empty($_POST['attendees'])) {
        $attendees = $_POST['attendees'];
        foreach ($attendees as $attendee_name) {
            if (!empty($attendee_name)) {
                $sql = "INSERT INTO Ebefor_attendees (meeting_id, attendee_name)
                        VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $meeting_id, $attendee_name);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    // Insert materials
    if (!empty($_POST['materials'])) {
        $materials = $_POST['materials'];
        foreach ($materials as $material_name) {
            if (!empty($material_name)) {
                $sql = "INSERT INTO Ebefor_materials (meeting_id, material_name)
                        VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $meeting_id, $material_name);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    // Insert attachments
    if (!empty($_FILES['attachments']['name'][0])) {
        for ($i = 0; $i < count($_FILES['attachments']['name']); $i++) {
            $file_name = $_FILES['attachments']['name'][$i];
            $file_path = 'uploads/' . $file_name;
            move_uploaded_file($_FILES['attachments']['tmp_name'][$i], $file_path);

            $sql = "INSERT INTO Ebefor_attachments (meeting_id, file_name, file_path)
                    VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $meeting_id, $file_name, $file_path);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Insert reminder
    if (!empty($reminder_time)) {
        $sql = "INSERT INTO Ebefor_reminders (meeting_id, reminder_time, reminder_method)
                VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $meeting_id, $reminder_time, $reminder_method);
        $stmt->execute();
        $stmt->close();
    }

    // Insert recurring meeting
    if ($recurring_meeting) {
        $sql = "INSERT INTO Ebefor_recurring_meetings (meeting_id, recurrence_frequency, recurrence_end_date)
                VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $meeting_id, $recurrence_frequency, $recurrence_end_date);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect to success page
    header('Location: display_meetings.php');
}
?>
