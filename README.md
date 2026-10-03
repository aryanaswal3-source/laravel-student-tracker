# 🎓 Laravel Student Tracker

> **A complete student management and tracking system built from scratch with Laravel.**

**Laravel Student Tracker** is an end-to-end web application designed to manage student information, track attendance, and provide useful analytics through a centralized dashboard.

The project was built **from scratch** using Laravel, PHP and MySQL, with a responsive frontend for managing and monitoring student data efficiently.

---

## 🚀 Features

### 👨‍🎓 Student Management

Complete student management functionality with:

- ➕ Add new students
- 👁️ View student details
- ✏️ Edit student information
- 🗑️ Delete student records
- 📋 View all students

### 📅 Attendance Tracking

Track and manage student attendance through the system.

- Mark student attendance
- Track attendance records
- View attendance information
- Monitor student attendance status

### 📊 Analytics Dashboard

A centralized dashboard provides an overview of student-related information.

- 👨‍🎓 Total students
- 📅 Attendance overview
- 📈 Student statistics
- 📊 Useful dashboard insights

---

## 🛠️ Tech Stack

| Technology | Usage |
|---|---|
| **Laravel** | Backend framework |
| **PHP** | Server-side programming |
| **MySQL** | Database |
| **Blade** | Template engine |
| **Bootstrap** | UI & responsive design |
| **JavaScript** | Frontend interactions |
| **HTML5** | Website structure |
| **CSS3** | Styling |

---

## 🏗️ Application Architecture

The application follows the Laravel MVC architecture:

```text
User
  │
  ▼
Routes
  │
  ▼
Controllers
  │
  ▼
Models
  │
  ▼
MySQL Database
  │
  ▼
Blade Views
  │
  ▼
User Interface
```

---

## 📂 Project Structure

```text
laravel-student-tracker/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │
│   └── Models/
│
├── database/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   ├── css/
│   ├── js/
│   └── images/
│
├── resources/
│   └── views/
│       ├── layouts/
│       ├── students/
│       ├── attendance/
│       └── dashboard/
│
├── routes/
│   └── web.php
│
├── .env.example
├── artisan
├── composer.json
└── README.md
```

---

## ⚙️ Installation

### 1. Clone the repository

```bash
git clone https://github.com/YOUR_USERNAME/laravel-student-tracker.git
```

### 2. Navigate to the project

```bash
cd laravel-student-tracker
```

### 3. Install PHP dependencies

```bash
composer install
```

### 4. Create environment file

```bash
cp .env.example .env
```

For Windows:

```bash
copy .env.example .env
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Configure database

Open the `.env` file and configure your MySQL database:

```env
DB_DATABASE=student_tracker
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run migrations

```bash
php artisan migrate
```

### 8. Start the Laravel development server

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

---

## 🗄️ Database

The application uses **MySQL** for storing student and attendance information.

The database structure is managed using Laravel migrations.

```text
Students
   │
   ├── Student Information
   │
   └── Attendance Records
```

---

## 📊 Dashboard

The dashboard acts as the central control panel of the application.

It provides an overview of:

- Total students
- Attendance information
- Student statistics
- Key tracking information

This allows users to quickly understand the current state of the student records.

---

## 🎯 Project Objectives

The main objectives of this project were:

- Build a complete Laravel application from scratch
- Implement CRUD functionality
- Work with relational databases
- Implement attendance tracking
- Create a useful analytics dashboard
- Practice Laravel MVC architecture
- Build a responsive web interface
- Gain experience with real-world application development

---

## 💡 What I Learned

While developing this project, I worked with:

- Laravel MVC architecture
- Laravel routing
- Controllers
- Eloquent Models
- Blade templates
- Database migrations
- MySQL database operations
- CRUD operations
- Form handling and validation
- Attendance management
- Dashboard development
- Bootstrap responsive UI
- JavaScript interactions

---

## 📸 Screenshots

Add your project screenshots here:

```markdown
![Dashboard](screenshots/dashboard.png)

![Students](screenshots/students.png)

![Attendance](screenshots/attendance.png)
```

---

## 🔮 Future Improvements

Possible future improvements include:

- 🔐 User authentication and role management
- 📧 Email notifications
- 📄 Export student records
- 📊 Advanced attendance reports
- 📥 Excel/PDF report generation
- 🔎 Advanced student search and filtering
- 📱 Progressive Web App support

---

## 👨‍💻 Developer

**Aryan Aswal**

B.Sc. IT | Web Developer

### Technologies

`PHP` • `Laravel` • `MySQL` • `HTML` • `CSS` • `JavaScript` • `Bootstrap`

---

## ⭐ Project

If you find this project useful or interesting, consider giving the repository a ⭐.

---

## ❤️ Built From Scratch

**Laravel Student Tracker** was designed and developed from scratch as a practical full-stack Laravel project.

### 🎓 Manage Students  
### 📅 Track Attendance  
### 📊 Understand Data

**Built with Laravel & ❤️ by Aryan Aswal**
