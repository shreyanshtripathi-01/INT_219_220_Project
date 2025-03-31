# INT_219_220_Project
HackProctor is a collaborative group project that provides a secure online assessment platform for evaluating hackathon candidates. Built with PHP, MySQL, and Tailwind CSS, it features real-time proctoring, automated scoring, and detailed analytics. Admins can create tests while candidates can take assessments in a monitored environment.

# HackProctor - Online Assessment Platform

HackProctor is a web-based proctored examination system designed specifically for conducting hackathon candidate assessments. The platform provides a secure and efficient way to evaluate candidates through standardized tests.

## Features

### For Administrators
- Create and manage test questions
- Set up test parameters (duration, passing score)
- Monitor test attempts in real-time
- View detailed analytics and performance reports
- Categorize questions by topic and difficulty
- Track candidate performance metrics

### For Candidates
- User-friendly registration and login system
- Take proctored tests with timer
- View immediate test results and feedback
- Track personal performance history
- Access practice tests and materials

## Technology Stack

### Frontend
- HTML5
- Tailwind CSS
- JavaScript
- Chart.js (for analytics visualization)

### Backend
- PHP
- MySQL Database
- PDO for database operations

## Project Structure
-[To be updated]


## Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(100) NOT NULL,
    uid VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'candidate') NOT NULL DEFAULT 'candidate',
    remember_token VARCHAR(64) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Questions Table
```sql
CREATE TABLE questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT NOT NULL,
    question_text TEXT NOT NULL,
    option_a TEXT NOT NULL,
    option_b TEXT NOT NULL,
    option_c TEXT NOT NULL,
    option_d TEXT NOT NULL,
    correct_answer CHAR(1) NOT NULL,
    category VARCHAR(50) NOT NULL,
    difficulty ENUM('easy', 'medium', 'hard') NOT NULL,
    FOREIGN KEY (admin_id) REFERENCES users(id)
);
```

## Installation

1. Clone the repository
```bash
git clone https://github.com/shreyanshtripathi-01/INT_219_220_Project
```

2. Set up your XAMPP environment
- Place the project folder in `htdocs` directory
- Start Apache and MySQL services

3. Database Configuration
- Create a database named 'hackproctor'
- Import the provided SQL schema
- Update database credentials in `Backend/PHP/config.php`

4. Access the Application
- Open your browser and navigate to `http://localhost/Project`

## Usage

### Administrator
1. Register as an admin user
2. Login with admin credentials
3. Access the admin dashboard
4. Create and manage questions
5. View analytics and reports

### Candidate
1. Register as a candidate
2. Login with registered credentials
3. Access available tests
4. Take tests and view results
5. Track performance history

## Security Features

- Password hashing using PHP's password_hash()
- Session-based authentication
- PDO prepared statements for SQL injection prevention
- Input validation and sanitization
- Role-based access control

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Authors

- Shreyansh Tripathi
  Contact: 14shreyansh2006@gmail.com
  GitHub: [@shreyanshtripathi-01](https://github.com/shreyanshtripathi-01)

- Shraddha Gupta
  Contact: 14shreyansh2006@gmail.com
  GitHub: [@shreyanshtripathi-01](https://github.com/shreyanshtripathi-01)

- Khushi Gupta
  Contact: 14shreyansh2006@gmail.com
  GitHub: [@shreyanshtripathi-01](https://github.com/shreyanshtripathi-01)

- Aastha Kumari
  Contact: 14shreyansh2006@gmail.com
  GitHub: [@shreyanshtripathi-01](https://github.com/shreyanshtripathi-01)

## Acknowledgments

- Tailwind CSS for the UI components
- Chart.js for data visualization
- XAMPP for the development environment
