
-- Create the authors table
CREATE TABLE authors (
    id SERIAL PRIMARY KEY,
    author VARCHAR(50) NOT NULL
);

-- Create the categories table
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    category VARCHAR(20) NOT NULL
);

CREATE TABLE quotes (
    id SERIAL PRIMARY KEY,
    quote TEXT NOT NULL,
    author_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (author_id) REFERENCES authors(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

INSERT INTO authors (author) VALUES
('Mark Twain'),
('Albert Einstein'),
('Maya Angelou'),
('Oscar Wilde'),
('Dr. Seuss');

INSERT INTO categories (category) VALUES
('Inspirational'),
('Educational'),
('Love'),
('Humor'),
('Commentary');

INSERT INTO quotes (quote, author_id, category_id) VALUES
--Twain
('The secret of getting ahead is getting started.',1,1),
('The only way to keep your health is to eat what you don’t want, drink what you don’t like, and do what you’d rather not.',1,2),
('When you fish for love, bait with your heart, not your brain.',1,3),
('Go to Heaven for the climate, Hell for the company.',1,4),
('The lack of money is the root of all evil.',1,5),

--Einstein
('Life is like riding a bicycle. To keep your balance, you must keep moving.',2,1),
('If you can’t explain it simply, you don’t understand it well enough.',2,2),
('When you are courting a nice girl an hour seems like a second. When you sit on a red-hot cinder a second seems like an hour. That’s relativity.',2,3),
('Coincidence is God’s way of remaining anonymous.',2,4),
('I know not with what weapons World War III will be fought, but World War IV will be fought with sticks and stones.',2,5),

--Maya
('If you don’t like something, change it. If you can’t change it, change your attitude.',3,1),
('Any book that helps a child to form a habit of reading, to make reading one of his deep and continuing needs, is good for him.',3,2),
('Love recognizes no barriers. It jumps hurdles, leaps fences, penetrates walls to arrive at its destination full of hope.',3,3),
('Nothing succeeds like success. Get a little success, and then just get a little more.',3,4),
('Won’t it be wonderful when black history and native American history and Jewish history and all of U.S. history is taught from one book. Just U.S. history.',3,5),

--Oscar
('Some cause happiness wherever they go; others whenever they go.',4,1),
('Experience is simply the name we give our mistakes.',4,2),
('To love oneself is the beginning of a lifelong romance.',4,3),
('When I was young I thought that money was the most important thing in life; now that I am old I know that it is.',4,4),
('Success is a science; if you have the conditions, you get the result.',4,5),

--Seuss
('You have brains in your head. You have feet in your shoes. You can steer yourself in any direction you choose. You’re on your own, and you know what you know. And you are the guy who’ll decide where to go.',5,1),
('Don’t cry because it’s over. Smile because it happened.',5,2),
('Unless someone like you cares a whole awful lot, nothing is going to get better. It’s not.',5,3),
('The main problem with writing in verse is, if your fourth line doesn’t come out right, you’ve got to throw four lines away and figure out a whole new way to attack the problem. So the mortality rate is terrific.',5,4),
('Every once in a while, I get mad. ’The Lorax’ came out of my being angry. The ecology books I’d read were dull... In ’The Lorax,’ I was out to attack what I think are evil things and let the chips fall where they might.',5,4);

