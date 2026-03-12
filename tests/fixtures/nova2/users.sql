INSERT INTO `nova_users` (`userid`, `username`, `password`, `email`, `status`, `created`, `modified`) VALUES
(1, 'janeway', '5f4dcc3b5aa765d61d8327deb882cf99', 'janeway@voyager.com', 'active',1609459200, 1609459200),
(2, 'chakotay', '5f4dcc3b5aa765d61d8327deb882cf99', 'chakotay@voyager.com', 'active',1609459200, 1609459200),
(3, 'tuvok', '5f4dcc3b5aa765d61d8327deb882cf99', 'tuvok@voyager.com', 'inactive',1609459200, 1609459200);

INSERT INTO `nova_user_prefs` (`userid`, `pref_key`, `pref_value`) VALUES
(1, 'timezone', 'UTC'),
(2, 'timezone', 'America/New_York');