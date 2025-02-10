-- Creating users table
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Inserting initial user data (make sure to hash the password in real applications)
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('admin', '$2y$10$E9.d1aF123bHsh/somenonsensehashedpassword', 'admin');
