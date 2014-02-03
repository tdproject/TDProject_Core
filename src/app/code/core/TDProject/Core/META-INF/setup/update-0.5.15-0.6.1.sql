INSERT INTO `user` (
    `user_id`, 
    `email`, 
    `username`, 
    `password`, 
    `enabled`, 
    `rate`, 
    `contracted_hours`, 
    `ldap_synced`, 
    `synced_at`
) VALUES (
    43, 
    'guest@techdivision.com', 
    'guest', 
    MD5('egal'), 
    '0', 
    '0', 
    '0', 
    '0', 
    NULL
);

INSERT INTO `role` (
    `role_id`, 
    `role_id_fk`, 
    `user_id_fk`, 
    `name`
) VALUES (
    NULL, 
    '3', 
    '43', 
    'guest'
);