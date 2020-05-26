<?php
return [
	'admin' => 
	[
		'menu' => 
		[
			'items' => 
			[
				[
					'title' => 'System',
					'icon' => 'fas fa-cog',
					'route' => 'javascript:void(0);',
					'id' => 'menu-system',
					'System' => [
						['title' => 'Staff', 'route' => 'administrator/staff', 'id' => 'menu-staff'],
						['title' => 'Role', 'route' => 'administrator/role', 'id' => 'menu-role']
					],
				]
			]
		],
		'role_types' =>
		[
			'administrator' => 'Administrator',
			'collector' => 'Collector',
			'office' => 'Office',
			'sale' => 'Sale',
			'agent' => 'Agent'
		],

		'front_refer_to' => 
		[
			'en' => [
			    ''     => "N/A",
				'east' => 'East',
				'west' => 'West',
				'north' => 'North',
				'south' => 'South'
			],
			'kh' => [
                ''     => "មិនស្គាល់",
				'east' => 'កើត',
				'west' => 'លិច',
				'north' => 'ជើង',
				'south' => 'ត្បូង'
			],
			'cn' => [
                ''     => "未知",
				'east' => '東',
				'west' => '西方',
				'north' => '北',
				'south' => '南'
			]
		],

		'services' => 
		[
			'orther_service' => 
			[
				'en' => [
					'slug-1' => 'General location',
					'slug-2' => 'Sport zone',
					'slug-3' => 'Kid garden',
					'slug-4' => 'Swimming pool',
					'slug-5' => 'Exercise clubs (gyms)',
					'slug-6' => 'Hot tub',
					'slug-7' => 'Sona',
					'slug-8' => 'Tennis courts',
					'slug-9' => 'Garden',
					// 'slug-10' => 'Car parking',
					// 'slug-11' => 'Reference stairs',
					// 'slug-12' => 'Elevator parts',
					'slug-13' => 'Backup electricity',
					'slug-14' => 'Electricity engine',
					// 'slug-15' => 'Street don\'t flood',
					'slug-16' => 'On the main road',
					'slug-17' => 'Business area'
				],
				'kh' => [
					'slug-1' => 'តំបន់ទូទៅ',
					'slug-2' => 'កន្លែងកីឡា',
					'slug-3' => 'សួនកុមា',
					'slug-4' => 'អាងហែលទឹក',
					'slug-5' => 'ក្លឹបហាត់ប្រា',
					'slug-6' => 'អាង​ទឹកក្តៅ',
					'slug-7' => 'សោណា',
					'slug-8' => 'កន្លែងលេងធិននី',
					'slug-9' => 'សួនច្បា',
					// 'slug-10' => 'ចំណតរថយ',
					// 'slug-11' => 'ជណ្តើរយោង',
					// 'slug-12' => 'ជណ្តើរយន្ត',
					'slug-13' => 'ភ្លើងបម្រុង',
					'slug-14' => 'ម៉ាសុីនភ្លើង',
					// 'slug-15' => 'អត់លិចទឹក',
					'slug-16' => 'នៅលើផ្លូវធំ',
					'slug-17' => 'តំបន់ពាណិជ្ជកម្ម'
				],
				'cn' => [
					'slug-1' => '活动区域',
					'slug-2' => '运动场',
					'slug-3' => '儿童乐园',
					'slug-4' => '游泳池',
					'slug-5' => '健身房',
					'slug-6' => '温泉',
					'slug-7' => '桑拿房',
					'slug-8' => '网球场',
					'slug-9' => '花园',
					// 'slug-10' => '停車',
					// 'slug-11' => '參考樓梯',
					// 'slug-12' => '電梯部件',
					'slug-13' => '备用电',
					'slug-14' => '发电机',
					// 'slug-15' => '街頭沒有洪水',
					'slug-16' => '主干道',
					'slug-17' => '商务洽谈区'
				]
			],
			'specials' => 
			[
				'en' => [
					// 'slug-1' => 'Equipped with all furniture',
					'slug-2' => 'VIRGINIA',
					'slug-3' => 'Air conditioning',
					'slug-4' => 'Internet / WiFi',
					'slug-5' => 'Cable TV',
					// 'slug-6' => 'Pets',
					// 'slug-7' => 'Real Estate Services'
				],
				'kh' => [
					// 'slug-1' => 'បំពាក់ដោយគ្រប់គ្រឿងសង្ហារិម',
					'slug-2' => 'វេរ៉ង់ដា',
					'slug-3' => 'ម៉ាស៊ីនត្រជាក់',
					'slug-4' => 'អ៊ីនធឺណិត / ប្រព័ន្ធវ៉ាយហ្វាយ',
					'slug-5' => 'ទូរទស្សន៍ខ្សែកាប',
					// 'slug-6' => 'សត្វចិញ្ចឹម',
					// 'slug-7' => 'សេវាកម្មអចលនៈទ្រព្យ'
				],
				'cn' => [
					// 'slug-1' => '配備所有家具',
					'slug-2' => '阳台',
					'slug-3' => '空调',
					'slug-4' => '网路、无线网路',
					'slug-5' => '有限电视',
					// 'slug-6' => '寵物',
					// 'slug-7' => '房地產服務'
				]
			]
			,
			'security' => 
			[
				'en' => [
					'slug-1' => 'Ringtone system',
					'slug-2' => 'Secure Video',
					'slug-3' => 'Reception Room 24/7',
					'slug-4' => 'Fire protection water system',
					'slug-5' => 'Fire alarm system',
					'slug-6' => 'Community Gate'
				],
				'kh' => [
					'slug-1' => 'ប្រព័ន្ធសំលេងរោទ៍',
					'slug-2' => 'វីដេអូសុវត្ថិភាព',
					'slug-3' => 'កន្លែងទទួលភ្ញៀវ ២៤/៧',
					'slug-4' => 'ប្រព័ន្ធទឹកការពារអគ្គីភ័យ',
					'slug-5' => 'ប្រព័ន្ធបន្លឺសំលេងពេលមានអគ្គីភ័យ',
					'slug-6' => 'ច្រកទ្វារួមរបស់សហគមន៍'
				],
				'cn' => [
					'slug-1' => '报警系统',
					'slug-2' => '监控系统',
					'slug-3' => '24小时接待',
					'slug-4' => '消防水系统',
					'slug-5' => '火警系统',
					'slug-6' => '社区门'
				]	
			]
		]
	]
];