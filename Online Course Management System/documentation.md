# Online Course Management System Documentation

## 1) Purpose of the Website
The purpose of the "Online Course Management System" is to provide a seamless and interactive platform for students to discover, enroll in, and manage educational courses. It aims to bridge the gap between learners and educational content by offering an easy-to-use interface where administrators can efficiently manage course offerings and user registrations, while students can track their educational progress.

## 2) Potential Audience and Needs
**Primary Audience: Students/Learners**
- **Needs**: Easy registration and login process, clear display of available courses, a personalized dashboard to track enrolled courses, the ability to unenroll if needed, and a way to update personal profile information.

**Secondary Audience: System Administrators**
- **Needs**: A secure portal to manage the platform, the ability to add, update, and delete course listings, capabilities to oversee registered users, and a reliable database system to ensure data integrity.

## 3) 8 Principles of Information Architecture
1. **Principle of Objects**: Treating content (Courses, Users) as living, breathing things. Each course has its own distinct properties (ID, name, description) and behaviors managed via the admin portal.
2. **Principle of Choices**: The system avoids overwhelming the user by keeping navigation simple. The dashboard provides clear, distinct choices: Edit Profile, View Enrollments, or Browse Courses.
3. **Principle of Disclosure**: Information is progressively disclosed. For example, the homepage shows a summary, while the 'Courses' page lists the courses, and further details are available upon enrollment.
4. **Principle of Exemplars**: The forms (like Registration or Edit Profile) use clear labels and dropdown exemplars (e.g., specific course categories like Web Development or Data Science) to guide user input.
5. **Principle of Front Doors**: Not all users will land on the homepage first. Navigation links are consistently placed in the header across all pages, ensuring users can find their bearings regardless of entry point.
6. **Principle of Multiple Classification**: Courses and user interests can be categorized in multiple ways (e.g., by topic such as Coding, Design, or Marketing), allowing flexible content discovery.
7. **Principle of Focused Navigation**: The navigation menu is clearly separated. Admins see 'Manage Courses' and 'Manage Users', while standard students only see relevant learning links.
8. **Principle of Growth**: The database and UI are structured to accommodate future growth. The `courses` and `users` tables can easily scale beyond the initial test data without requiring a UI overhaul.

## 4) ERD / Relational Schema
The database (`elearning`) consists of five main tables interconnected as follows:

- **`users`**: `id` (PK), `name`, `email`, `password`, `gender`, `course`, `interests`
- **`courses`**: `course_id` (PK), `course_name`, `description`
- **`enrollments`**: `id` (PK), `user_id` (FK -> users.id), `course_id` (FK -> courses.course_id)
  *(This is a junction table resolving the many-to-many relationship between users and courses).*
- **`messages`**: `id` (PK), `name`, `email`, `message`
- **`admin`**: `id` (PK), `username`, `password`

**Relationships**:
- A **User** can have multiple **Enrollments** (1 to Many).
- A **Course** can have multiple **Enrollments** (1 to Many).
- When a user or course is deleted, their respective enrollments are cascaded and removed automatically.

## 5) References
- IEEE Standards Association. (2023). *IEEE Citation Reference*. [Online]. Available: https://ieeeauthorcenter.ieee.org
- W3Schools. (2026). *HTML, CSS, and JavaScript Tutorials*. [Online]. Available: https://www.w3schools.com
- PHP Documentation Group. (2026). *PHP: Hypertext Preprocessor Manual*. [Online]. Available: https://www.php.net/manual/en/
- Oracle Corporation. (2026). *MySQL 8.0 Reference Manual*. [Online]. Available: https://dev.mysql.com/doc/refman/8.0/en/
