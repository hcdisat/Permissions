<?php namespace HcDisat\Permissions\Database\Seeds;

use HcDisat\Permissions\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPositionRoles();
        $this->createAddedFunctionalityRoles();
    }

    protected function createPositionRoles()
    {
        $positionRole = Role::create([
            'name' => 'Position',
            'slug' => 'position'
        ]);

        $roles = [
            [
                'name' => 'Project VA',
                'slug' => str_slug('Project VA')
            ],
            [
                'name' => 'Dedicated VA',
                'slug' => str_slug('Dedicated VA')
            ],
            [
                'name' => 'Accountant',
                'slug' => str_slug('Accountant')
            ],
            [
                'name' => 'Project Manager',
                'slug' => str_slug('Project Manager')
            ],
            [
                'name' => 'Management',
                'slug' => str_slug('Management')
            ],
            [
                'name' => 'Apprentice VA',
                'slug' => str_slug('Apprentice VA')
            ],
            [
                'name' => 'Senior VA',
                'slug' => str_slug('Senior VA')
            ],
            [
                'name' => 'EA to CEO',
                'slug' => str_slug('EA to CEO')
            ],
            [
                'name' => 'IAC-EZ Only',
                'slug' => str_slug('IAC-EZ Only')
            ],
            [
                'name' => 'Intern',
                'slug' => str_slug('Intern')
            ],
            [
                'name' => 'Assistant VA',
                'slug' => str_slug('Assistant VA')
            ],
            [
                'name' => 'Client Advocate',
                'slug' => str_slug('Client Advocate')
            ],
            [
                'name' => 'Paralegal',
                'slug' => str_slug('Paralegal')
            ],
            [
                'name' => 'Human Resources',
                'slug' => str_slug('Human Resources')
            ],
            [
                'name' => 'Assistant General Manager',
                'slug' => str_slug('Assistant General Manager')
            ],
            [
                'name' => 'General Manager',
                'slug' => str_slug('General Manager')
            ],
            [
                'name' => 'Board',
                'slug' => str_slug('Board')
            ],
            [
                'name' => 'Misc. Other',
                'slug' => str_slug('Misc. Other')
            ],
            [
                'name' => 'Client Advocate Team Leader',
                'slug' => str_slug('Client Advocate Team Leader')
            ],
            [
                'name' => 'Compliance Coordinator',
                'slug' => str_slug('Compliance Coordinator')
            ],
            [
                'name' => 'Customer Service & Sales Manager',
                'slug' => str_slug('Customer Service & Sales Manager')
            ],
            [
                'name' => 'Executive Management',
                'slug' => str_slug('Executive Management')
            ],
            [
                'name' => 'Team Leader',
                'slug' => str_slug('Team Leader')
            ],
            [
                'name' => 'JSB Team Leader',
                'slug' => str_slug('JSB Team Leader')
            ],
            [
                'name' => 'CVAL Dept Manager',
                'slug' => str_slug('CVAL Dept Manager')
            ],
            [
                'name' => 'Master Administrator',
                'slug' => str_slug('Master Administrator')
            ],
            [
                'name' => 'Test VA',
                'slug' => str_slug('Test VA')
            ],
            [
                'name' => 'Bookkeeper',
                'slug' => str_slug('Bookkeeper')
            ],
            [
                'name' => 'Administration Manager',
                'slug' => str_slug('Administration Manager')
            ],
            [
                'name' => 'Office Assistant',
                'slug' => str_slug('Office Assistant')
            ],
            [
                'name' => 'Success Coach',
                'slug' => str_slug('Success Coach')
            ],
            [
                'name' => 'Hidden',
                'slug' => str_slug('hidden')
            ],

        ];

        $children = [];
        foreach ($roles as $role) {
            $children[] = Role::create($role)->id;
        }

        $positionRole->children()->attach($children);
    }

    protected function createAddedFunctionalityRoles()
    {
        $cva = Role::create([
            'name' => 'Added Functionality',
            'slug' => 'cva_permissions',
            'description' => 'Main app role permissions'
        ]);

        $roles = [
            [
                'name' => 'Portfolio',
                'slug' => 'portfolio',
                'description' => 'Portfolio Manager',
            ],
            [
                'name' => 'Track Load',
                'slug' => 'track_load',
                'description' => 'Track on Relationships and Load',
            ],
            [
                'name' => 'Mentoring',
                'slug' => 'mentoring',
                'description' => 'Mentoring?',
            ]
        ];

        $children = [];
        foreach ($roles as $role) {
            $children[] = Role::create($role)->id;
        }

        $cva->children()->attach($children);
    }
}