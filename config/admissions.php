<?php

return [
    /**
     * Admission notification recipients (admin side).
     *
     * Comma-separated list in .env:
     * ADMISSION_ADMIN_EMAILS="a@piu.edu,b@piu.edu"
     */
    'admin_recipients' => array_values(array_filter(array_map('trim', explode(',', env('ADMISSION_ADMIN_EMAILS', 'piuacademicaffairs@gmail.com'))))),

    /**
     * Optional CC recipients for every admission notification.
     *
     * Comma-separated list in .env:
     * ADMISSION_CC_EMAILS="cc1@piu.edu,cc2@piu.edu"
     */
    // Default includes PIU admissions coordinator.
    'cc_recipients' => array_values(array_filter(array_map('trim', explode(',', env('ADMISSION_CC_EMAILS', 'thantarhlaing.piu@gmail.com'))))),

    /**
     * Program manager email mapping by course_id.
     *
     * Update this list when course ids change.
     */
    'program_managers' => [
        1 => 'thantarhlaing.piu@gmail.com',
        2 => 'thantarhlaing.piu@gmail.com',
        3 => 'intellay@gmail.com',
        4 => 'oketama020@gmail.com',
        5 => 'thantarhlaing.piu@gmail.com',
        6 => 'ohmar.mme@gmail.com',
        7 => 'mayyimyint.pdopiu@gmail.com',
        8 => 'thantarhlaing.piu@gmail.com',
        9 => 'moet.khaing@gmail.com',
    ],
];

