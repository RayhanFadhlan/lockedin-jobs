<?php

use database\Database;
$db = Database::getInstance()->getConnection();

$query = '';

// Seeding for User table
$user = 'INSERT INTO "User" (email, password, role, nama) VALUES
("jobseeker1@example.com", "$2y$10$1hS31SDQHHjYMWCgDoS2m.YWmVhsOSOBeUgVSaPDB191293iY9OYS", "jobseeker", "Job Seeker One"),
("jobseeker2@example.com", "$2y$10$1hS31SDQHHjYMWCgDoS2m.YWmVhsOSOBeUgVSaPDB191293iY9OYS", "jobseeker", "Job Seeker Two"),
("company1@example.com", "$2y$10$1hS31SDQHHjYMWCgDoS2m.YWmVhsOSOBeUgVSaPDB191293iY9OYS", "company", "Company One"),
("company2@example.com", "$2y$10$1hS31SDQHHjYMWCgDoS2m.YWmVhsOSOBeUgVSaPDB191293iY9OYS", "company", "Company Two");';

// Seeding for CompanyDetail table
$comp_det = 'INSERT INTO "CompanyDetail" (user_id, lokasi, about) VALUES
(3, "Jakarta", "A well-known tech company in Indonesia."),
(4, "Bandung", "An innovative startup in the health industry.");';

// Seeding for Lowongan table
$lowongan = 'INSERT INTO "Lowongan" (company_id, posisi, deskripsi, jenis_pekerjaan, jenis_lokasi, is_open, created_at, updated_at) VALUES
(3, "Software Engineer", "Develop and maintain our main product.", "Full-time", "Hybrid", TRUE, "2024-09-01 10:00:00", "2024-09-10 14:00:00"),
(3, "Product Manager", "Lead our product development team.", "Full-time", "On-site", FALSE, "2024-08-15 09:30:00", "2024-09-20 11:00:00"),
(4, "Marketing Intern", "Support our marketing team.", "Internship", "Remote", TRUE, "2024-07-20 12:15:00", "2024-08-05 12:00:00"),
(4, "Graphic Designer", "Create graphics for our campaigns.", "Part-time", "Hybrid", FALSE, "2024-06-25 15:45:00", "2024-07-01 09:30:00");';

// Seeding for AttachmentLowongan table
$attc_low = 'INSERT INTO "AttachmentLowongan" (lowongan_id, file_path) VALUES
(1, "storage/uploads/attach_1.png"),
(2, "storage/uploads/attach_2.png"),
(3, "storage/uploads/attach_3.png"),
(4, "storage/uploads/attach_4.png");';

// Seeding for Lamaran table
$lamaran = 'INSERT INTO "Lamaran" (user_id, lowongan_id, cv_path, video_path, status, status_reason, created_at) VALUES
(1, 1, "storage/cv/cv_1.pdf", "storage/videos/video_1.mp4", "waiting", "Pending review by HR", "2024-10-01 13:00:00"),
(1, 2, "storage/cv/cv_2.pdf", "storage/videos/video_2.mp4", "accepted", "Candidate passed the initial interview", "2024-09-28 09:00:00"),
(2, 3, "storage/cv/cv_3.pdf", "storage/videos/video_3.mp4", "rejected", "Candidate did not meet qualifications", "2024-09-15 10:30:00"),
(2, 4, "storage/cv/cv_4.pdf", "storage/videos/video_4.mp4", "waiting", "Pending final decision", "2024-09-10 11:45:00");';

$query = $user.$comp_det.$lowongan.$attc_low.$lamaran;
$stmt = $db->prepare($query);
$stmt->execute();
