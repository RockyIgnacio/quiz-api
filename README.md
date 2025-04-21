## Quiz API

## API Endpoints
Here are the available endpoints :

For fetching all activities.
GET https://www.quiz-api.42web.io/get-exam-activities

For fetching all question of activity one.
GET https://www.quiz-api.42web.io/get-activity-questions/1

For fetching all question of activity two.
GET https://www.quiz-api.42web.io/get-activity-questions/2

## Database Query Schema:

```nginx
CREATE TABLE exams (
    exam_id INT PRIMARY KEY,
    exam_name VARCHAR(50) NOT NULL,
    heading TEXT NOT NULL,
    active_flag CHAR(1) DEFAULT 'n'
);

INSERT INTO exams (exam_id, exam_name, heading, active_flag)
VALUES (1, 'Error Find', 'This game teaches you to find mistakes in written text.', 'y');

CREATE TABLE activities (
    activity_id INT PRIMARY KEY,
    exam_id INT,
    activity_name VARCHAR(50) NOT NULL,
    `order` INT NOT NULL
);

INSERT INTO activities (activity_id, exam_id, activity_name, `order`)
VALUES 
    (1, 1, 'Activity One', 1),
    (2, 1, 'Activity Two', 2);

CREATE TABLE question_rounds (
    question_round_id INT PRIMARY KEY,
    activity_id INT,
    round_title VARCHAR(50) NOT NULL,
    `order` INT NOT NULL
);

INSERT INTO question_rounds (question_round_id, activity_id, round_title, `order`)
VALUES 
    (1, 1, 'Round 1', 1),
    (2, 2, 'Round 1', 1),
    (3, 2, 'Round 2', 2);

CREATE TABLE questions (
    question_id INT PRIMARY KEY,
    question_round_id INT,
    stimulus VARCHAR(255) NOT NULL,
    `order` INT NOT NULL,
    user_answers JSON,
    feedback VARCHAR(255) NOT NULL
);

INSERT INTO questions (question_id, question_round_id, stimulus, `order`, user_answers, feedback)
VALUES 
    (1, 1, 'Watching films at home is *more cheaper* than at the cinema.', 1, '[]', 'Watching films at home is *cheaper* than at the cinema.'),
    (2, 1, 'On the one hand, small cameras are comfortable. *In the other hand*, larger ones take better photos.', 2, '[]', 'On the one hand, small cameras are comfortable. *On the other hand*, larger ones take better photos.'),
    (3, 2, 'Watching films at home is *more cheaper* than at the cinema.', 1, '[]', 'Watching films at home is *cheaper* than at the cinema.'),
    (4, 2, 'On the one hand, small cameras are comfortable. *In the other hand*, larger ones take better photos.', 2, '[]', 'On the one hand, small cameras are comfortable. *On the other hand*, larger ones take better photos.'),
    (5, 3, 'I can''t go out because I *haven''t finished* my homework yet.', 1, '[]', 'I can''t go out because I *haven''t finished* my homework yet.'),
    (6, 3, 'My friend *like listening* to songs in English', 2, '[]', 'My friend *likes listening* to songs in English');


CREATE TABLE answers (
    answer_id INT PRIMARY KEY,
    question_id INT,
    answer TEXT NOT NULL,
    is_correct BOOLEAN NOT NULL
);

INSERT INTO answers (answer_id, question_id, answer, is_correct)
VALUES 
    (1, 1, 'Correct', false),
    (2, 1, 'Incorrect', true),
    (3, 2, 'Correct', false),
    (4, 2, 'Incorrect', true),
    (9, 3, 'Correct', false),
    (10, 3, 'Incorrect', true),
    (11, 4, 'Correct', false),
    (12, 4, 'Incorrect', true),
    (13, 5, 'Correct', true),
    (14, 5, 'Incorrect', false),
    (15, 6, 'Correct', false),
    (16, 6, 'Incorrect', true);
```