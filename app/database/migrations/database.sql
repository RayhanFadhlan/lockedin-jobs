-- Table: User
CREATE TABLE "User" (
    user_id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) CHECK (role IN ('jobseeker', 'company')) NOT NULL,
    nama VARCHAR(255) NOT NULL
);

-- Table: Company Detail
CREATE TABLE "CompanyDetail" (
    user_id INT REFERENCES "User"(user_id) ON DELETE CASCADE,
    lokasi VARCHAR(255),
    about TEXT,
    PRIMARY KEY (user_id)
);

-- Table: Lowongan
CREATE TABLE "Lowongan" (
    lowongan_id SERIAL PRIMARY KEY,
    company_id INT REFERENCES "User"(user_id) ON DELETE SET NULL,
    posisi VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    jenis_pekerjaan VARCHAR(50) CHECK(role IN('Internship', 'Part-time', 'Full-time')),
    jenis_lokasi VARCHAR(50) CHECK(role IN('Hybrid', 'Remote', 'On-site')),
    is_open BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- Table: Attachment Lowongan
CREATE TABLE "AttachmentLowongan" (
    attachment_id SERIAL PRIMARY KEY,
    lowongan_id INT REFERENCES "Lowongan"(lowongan_id) ON DELETE CASCADE,
    file_path VARCHAR(255) NOT NULL
);

-- Table: Lamaran
CREATE TABLE "Lamaran" (
    lamaran_id SERIAL PRIMARY KEY,
    user_id INT REFERENCES "User"(user_id) ON DELETE CASCADE,
    lowongan_id INT REFERENCES "Lowongan"(lowongan_id) ON DELETE CASCADE,
    cv_path VARCHAR(255),
    video_path VARCHAR(255),
    status VARCHAR(50) CHECK (status IN ('accepted', 'rejected', 'waiting')) NOT NULL,
    status_reason TEXT,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);
