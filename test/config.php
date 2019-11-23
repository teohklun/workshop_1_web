<?php

//call the define data like PATH_C etc
include_once 'defineData.php';

//description of the configModule index key meaning

// example of home
// PAGEMODULE mean module, cause this index is the same array for another module so can merge
// module => home, home here mean the module name
// home => commonSettings, a shared setting list of array, could be shared parameter in future
//  commonSettings => permissionAll , mean the available user type to use this module om all action, 
//    here 0 => staff 1 => admin
//      so userType 0 and 1 is authorised all the action inside this module

// example of patient
// PAGEMODULE mean module, cause this index is the same array for another module so can merge
// module => patient, patient here mean the module name
// patient => commonSettings, a shared setting list of array, could be shared parameter in future
//  commonSettings => permissionAll , mean the available user type to use this module, 
//    here 1 => admin 
//      so userType 1(admin) is authorised all the action inside this module
//    patient => action, list of action name inside this module
//      action => index, the configuration inside module patient, action index
//        index => allowedUserType, the alowed user inside this page, 0,1
//          so staff and admin can use
//        create => configFields, the configurationFields inside this page, may got shared setting in the future
//            configFields => fields, the setting of fields
//              fields => Debt(field name as index)
//               fieldName => label, in the future this field will be the label if the page of this field not set
//               fieldName => fieldOption, the configuration of this field
//                fieldOption => validation, the list of validation to be use in this field
//                  fieldOption => validationType, example number, required, length, email, date, time, datetime and etc
//                    for the detail setting, please see {validationType}.php in templates/validation
//        delete => allowedUserType, the alowed user inside this page, 1
//          so admin can use
//

function getConfig() {
  $configModuleHome = [
    PAGEMODULE => [
      'home' => [
        'commonSettings' => [
          'permissionAll' => [
            0,1
          ]
        ],
      ],
    ],
  ];
  
  $configModuleUser = [
    PAGEMODULE => [
      'user' => [
        'commonSettings' => [
          'permissionAll' => [
            1,
          ]
        ],
        'action' => [
          'create' => [
            'allowedUserType' => [
              1
            ],
            'configFields' => [
              'fields' => [
                'Username' => [
                  'label' => 'Username',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'required',
                    'length' => [
                      5, 255
                    ]
                  ],
                ],
                'Password' => [
                  'label' => 'Password',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'required',
                      'length' => [
                          6, 255
                      ],
                  ],
                ],
                'ConfirmPassword' => [
                  'label' => 'Confirm Password',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'required',
                      'length' => [
                          6, 255
                      ],
                      'compare' => 'Password',
                  ],
                ],
                'ContactNo' => [
                  'label' => 'Contact No',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'number',
                  ],
                ],
                'Name' => [
                  'label' => 'Name',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                    'required',
                    'length' => 
                        COMMONSTRINGLENGTH
                  ],
                ],
                'IC' => [
                  'label' => 'IC',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'number',
                    'required',
                    'length' => 12
                  ],
                ],
                'Email' => [
                  'label' => 'Email',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'email',
                  ],
                ],
                'City' => [
                  'label' => 'City',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => 
                          COMMONSTRINGLENGTH
                  ],
                ],
                'Street' => [
                  'label' => 'Street',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => 
                          COMMONSTRINGLENGTH
                  ],
                ],
              ]
            ]
          ],
          'edit' => [
            'allowedUserType' => [
              1
            ],
            'configFields' => [
              'fields' => [
                'Username' => [
                  'label' => 'Username',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'required',
                    'length' => [
                      5, 255
                    ]
                  ],
                ],
                'Password' => [
                  'label' => 'Password',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => [
                          6, 255
                      ],
                  ],
                ],
                'ConfirmPassword' => [
                  'label' => 'Confirm Password',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => [
                          6, 255
                      ],
                      'compare' => 'Password',
                  ],
                ],
                'ContactNo' => [
                  'label' => 'Contact No',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'number',
                  ],
                ],
                'Name' => [
                  'label' => 'Name',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                    'number' => ['!'],
                    'required',
                    'length' => 
                        COMMONSTRINGLENGTH
                  ],
                ],
                'IC' => [
                  'label' => 'IC',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'number',
                    'required',
                    'length' => 12
                  ],
                ],
                'Email' => [
                  'label' => 'Email',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'email',
                  ],
                ],
                'City' => [
                  'label' => 'City',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => 
                          COMMONSTRINGLENGTH
                  ],
                ],
                'Street' => [
                  'label' => 'Street',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => 
                          COMMONSTRINGLENGTH
                  ],
                ],
              ]
            ]
          ],
        ],
      ],
    ],
  ];
  
  $configModulePatient = [
    PAGEMODULE => [
      'patient' => [
        'commonSettings' => [
          'permissionAll' => [
            1,
          ],
        ],
        'action' => [
          'index' => [
            'allowedUserType' => [
              0, 1
            ],
          ],
          'create' => [
            'allowedUserType' => [
              0, 1
            ],
            'configFields' => [
              'fields' => [
                'Debt' => [
                  'label' => 'Debt',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                    'number' => [0, '>='],
                    'required',
                  ],
                ],
                'ContactNo' => [
                  'label' => 'Contact No',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'number',
                  ],
                ],
                'Name' => [
                  'label' => 'Name',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                    'required',
                    'length' => 
                        COMMONSTRINGLENGTH
                  ],
                ],
                'IC' => [
                  'label' => 'IC',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'number',
                    'required',
                    'length' => 12
                  ],
                ],
                'Email' => [
                  'label' => 'Email',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'email',
                  ],
                ],
                'City' => [
                  'label' => 'City',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => 
                          COMMONSTRINGLENGTH
                  ],
                ],
                'Street' => [
                  'label' => 'Street',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => 
                          COMMONSTRINGLENGTH
                  ],
                ],
              ]
            ]
          ],
          'edit' => [
            'allowedUserType' => [
              0, 1
            ],
            'configFields' => [
              'fields' => [
                'Debt' => [
                  'label' => 'Debt',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                    'number' => [0, '>='],
                    'required',
                  ],
                ],
                'ContactNo' => [
                  'label' => 'Contact No',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'number',
                  ],
                ],
                'Name' => [
                  'label' => 'Name',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                    'required',
                    'length' => 
                        COMMONSTRINGLENGTH
                  ],
                ],
                'IC' => [
                  'label' => 'IC',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'number',
                    'required',
                    'length' => 12
                  ],
                ],
                'Email' => [
                  'label' => 'Email',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'email',
                  ],
                ],
                'City' => [
                  'label' => 'City',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => 
                          COMMONSTRINGLENGTH
                  ],
                ],
                'Street' => [
                  'label' => 'Street',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => 
                          COMMONSTRINGLENGTH
                  ],
                ],
              ]
            ]
          ],
          'delete' => [
            'allowedUserType' => [
              1
            ],
          ],
          'detail' => [
            'allowedUserType' => [
              0,1
            ],
          ],
        ],
      ],
    ]
  ];
  
  $configModuleDoctor = [
    PAGEMODULE => [
      'doctor' => [
        'commonSettings' => [
          'permissionAll' => [
            1
          ],
        ],
        'action' => [
          'index' => [
            'allowedUserType' => [
              0,1
            ]
          ],
          'create' => [
            'allowedUserType' => [
              1
            ],
            'configFields' => [
              'fields' => [
                'Professional' => [
                  'label' => 'Professional',
                  'fieldOption' => [
                  ],
                  'validation' => [
                      'required',
                  ],
                ],
                'ContactNo' => [
                  'label' => 'Contact No',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'number',
                  ],
                ],
                'Name' => [
                  'label' => 'Name',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                    'required',
                    'length' => 
                        COMMONSTRINGLENGTH
                  ],
                ],
                'IC' => [
                  'label' => 'IC',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'number',
                    'required',
                    'length' => 12
                  ],
                ],
                'Email' => [
                  'label' => 'Email',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'email',
                  ],
                ],
                'City' => [
                  'label' => 'City',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => 
                          COMMONSTRINGLENGTH
                  ],
                ],
                'Street' => [
                  'label' => 'Street',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => 
                          COMMONSTRINGLENGTH
                  ],
                ],
              ]
            ]
          ],
          'edit' => [
            'allowedUserType' => [
              1
            ],
            'configFields' => [
              'fields' => [
                'Professional' => [
                  'label' => 'Professional',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'required',
                  ],
                ],
                'ContactNo' => [
                  'label' => 'Contact No',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'number',
                  ],
                ],
                'Name' => [
                  'label' => 'Name',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                    'required',
                    'length' => 
                        COMMONSTRINGLENGTH
                  ],
                ],
                'IC' => [
                  'label' => 'IC',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'number',
                    'required',
                    'length' => 12
                  ],
                ],
                'Email' => [
                  'label' => 'Email',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'email',
                  ],
                ],
                'City' => [
                  'label' => 'City',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => 
                          COMMONSTRINGLENGTH
                  ],
                ],
                'Street' => [
                  'label' => 'Street',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                      'length' => 
                          COMMONSTRINGLENGTH
                  ],
                ],
              ]
            ]
          ],
          'delete' => [
            'allowedUserType' => [
              1
            ],
          ],
          'detail' => [
            'allowedUserType' => [
              0,1
            ],
          ],
        ],
      ],
    ]
  ];
  
  $configModuleSchedule = [
    PAGEMODULE => [
      'schedule' => [
        'commonSettings' => [
          'permissionAll' => [
            1
          ],
        ],
        'action' => [
          'index' => [
            'allowedUserType' => [
              0,1
            ]
          ],
          'create' => [
            'allowedUserType' => [
              0, 1
            ],
            'configFields' => [
              'fields' => [
                'Date' => [
                  'label' => 'Date',
                  'fieldOption' => [
                  ],
                  'validation' => [
                      'required',
                      'date',
                  ],
                ],
                'DoctorID' => [
                  'label' => 'DoctorID',
                  'fieldOption' => [
                  ],
                  'validation' => [
                      'required',
                      'number',
                  ],
                ],
                'StartTime' => [
                  'label' => 'StartTime',
                  'fieldOption' => [
                  ],
                  'validation' => [
                      'required',
                      'time',
                  ],
                ],
                'EndTime' => [
                  'label' => 'EndTime',
                  'fieldOption' => [
                  ],
                  'validation' => [
                      'required',
                      'time',
                  ],
                ],
              ]
            ]
          ],
          'edit' => [
            'allowedUserType' => [
              0, 1
            ],
            'configFields' => [
              'fields' => [
                'Date' => [
                  'label' => 'Date',
                  'fieldOption' => [
                  ],
                  'validation' => [
                      'required',
                      'date',
                  ],
                ],
                'DoctorID' => [
                  'label' => 'DoctorID',
                  'fieldOption' => [
                  ],
                  'validation' => [
                      'required',
                      'number',
                  ],
                ],
                'StartTime' => [
                  'label' => 'StartTime',
                  'fieldOption' => [
                  ],
                  'validation' => [
                      'required',
                      'time',
                  ],
                ],
                'EndTime' => [
                  'label' => 'EndTime',
                  'fieldOption' => [
                  ],
                  'validation' => [
                      'required',
                      'time',
                  ],
                ],
              ]
            ]
          ],
          'delete' => [
            'allowedUserType' => [
              1
            ],
          ],
          'detail' => [
            'allowedUserType' => [
              0,1
            ],
          ],
        ],
      ],
    ]
  ];
  
  $configModuleAppointment = [
    PAGEMODULE => [
      'appointment' => [
        'commonSettings' => [
          'permissionAll' => [
            1
          ],
        ],
        'action' => [
          'index' => [
            'allowedUserType' => [
              0, 1
            ],
          ],
          'create' => [
            'allowedUserType' => [
              0, 1
            ],
          ],
          'edit' => [
            'allowedUserType' => [
              0, 1
            ],
            'configFields' => [
              'fields' => [
                'PatientID' => [
                  'label' => 'PatientID',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'required',
                    'number'
                  ],
                ],
                'Price' => [
                  'label' => 'Price',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'required',
                    'number'
                  ],
                ],
                'TreatmentDesc' => [
                  'label' => 'TreatmentDesc',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'required',
                    'length' => [3, 255]
                  ],
                ],
              ]
            ]
          ],
          'createDetail' => [
            'configFields' => [
              'fields' => [
                'Remark' => [
                  'label' => 'Remark',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'length' => [3, 255],
                  ],
                ],
                'TreatmentDesc' => [
                  'label' => 'TreatmentDesc',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'length' => [3, 255],
                  ],
                ],
                'Price' => [
                  'label' => 'Price',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'number' => [0, '>'],
                    'required',
                  ],
                ],
                'PatientID' => [
                  'label' => 'PatientID',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'number',
                    'required',
                  ],
                ],
              ]
            ]
          ],
          'delete' => [
            'allowedUserType' => [
              1
            ],
          ],
          'markComplete' => [
            'allowedUserType' => [
              0,1
            ],
          ],
          'markUnComplete' => [
            'allowedUserType' => [
              0,1
            ],
          ],
        ],
      ],
    ]
  ];
  
  $configModuleReport = [
    PAGEMODULE => [
      'report' => [
        'commonSettings' => [
          'permissionAll' => [
            1,
          ],
        ],
        'action' => [
          'patient' => [
            'allowedUserType' => [
              1
            ],
            'configFields' => [
              'fields' => [
                'Debt' => [
                  'label' => 'Debt',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'number' => [0, '>='],
                  ],
                ],
                'IC' => [
                  'label' => 'IC',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'number',
                  ],
                ],
                'Email' => [
                  'label' => 'Email',
                  'fieldOption' => [
                  ],
                  'validation' => [
                  ],
                ],
                'ContactNo' => [
                  'label' => 'ContactNo',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'number',
                  ],
                ],
                'ContactNo' => [
                  'label' => 'ContactNo',
                  'fieldOption' => [
                  ],
                  'validation' => [
                    'number',
                  ],
                ],
                'City' => [
                  'label' => 'City',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                  ],
                ],
                'Street' => [
                  'label' => 'Street',
                  'fieldOption' => [
                    
                  ],
                  'validation' => [
                          
                  ],
                ],
              ]
            ]
          ],
        ],
      ],
    ]
  ];

  // add the individual configmodule to configModule then merge it as one config when system finding.
  $configModule = [];
  $configModule[] = $configModuleHome;
  $configModule[] = $configModuleUser;
  $configModule[] = $configModulePatient;
  $configModule[] = $configModuleDoctor;
  $configModule[] = $configModuleSchedule;
  $configModule[] = $configModuleAppointment;
  $configModule[] = $configModuleReport;
  $config = [];
  foreach ($configModule as $key => $value) {
    $config = array_merge_recursive($config, $value);
  }
  return $config;
}

$config = getConfig();
/**
 * predefined errorMessage when permission failed.
 *
 */
$errorMessageWithRbac = 'Sorry, Permission not allowed. Contact admin.';

/**
 * Configuration for database connection
 *
 */

$host       = "localhost";
$dbUsername   = "root";
$dbPassword   = "";
$dbname     = "test";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );


