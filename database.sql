CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id BIGINT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    image_path VARCHAR(255) DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 0,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE roles (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(250) NOT NULL
);

CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    is_active TINYINT(1) DEFAULT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

CREATE TABLE topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(1050) DEFAULT NULL,
    content VARCHAR(255) DEFAULT NULL,
    video_path VARCHAR(255) DEFAULT NULL,
    attachment_path VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    course_id INT DEFAULT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id)
);


CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(1050) DEFAULT NULL,
    feature_image VARCHAR(250) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    category_id BIGINT DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
CREATE TABLE categories (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

