UPDATE tbt_keyuser_marked_assign
INNER JOIN (
	select ka.id, u.employee_id, d.`function`
	from tbt_keyuser_marked_assign ka
	LEFT JOIN tbt_user u ON u.employee_id = ka.assign_to
	LEFT JOIN tbt_user_position up ON up.employee_id = u.employee_id
	LEFT JOIN tbm_position p ON p.id = up.position_id
	LEFT JOIN tbm_department d ON d.id = p.department_id
	where ka.function  is NULL
) as t ON t.id = tbt_keyuser_marked_assign.id
SET tbt_keyuser_marked_assign.`function` = t.`function`;



ALTER TABLE `tbt_quotation`
ADD INDEX `index_contract_id` (`contract_id`) USING BTREE ;

