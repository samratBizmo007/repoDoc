<?php
$head = [
	'Email',
	'Name',
	'Account Created At'	
];

$this->Csv->addRow($head);

if(!empty($users)) {
	foreach ($users as $user) {
		$line = [
			'Email'	=> $user->email,
			'Name' => $user->full_name,
			'Account Created At' => $user->created_date 
		];
		
		$this->Csv->addRow($line);
	}
}

echo  $this->Csv->render(true);