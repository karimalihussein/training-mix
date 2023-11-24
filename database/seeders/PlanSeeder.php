<?php

declare(strict_types=1);

namespace Database\Seeders;

use Bpuig\Subby\Models\Plan;
use Bpuig\Subby\Models\PlanFeature;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $freePlan = Plan::create([
            'tag' => 'free',
            'name' => 'Free Plan',
            'description' => 'For small businesses',
            'price' => 0.00,
            'signup_fee' => 0.00,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 15,
            'trial_interval' => 'day',
            'grace_period' => 1,
            'grace_interval' => 'day',
            'tier' => 0,
            'currency' => 'JOD',
        ]);

        $basicPlan = Plan::create([
            'tag' => 'basic',
            'name' => 'Basic Plan',
            'description' => 'For small businesses',
            'price' => 50.00,
            'signup_fee' => 1.99,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 15,
            'trial_interval' => 'day',
            'grace_period' => 1,
            'grace_interval' => 'day',
            'tier' => 1,
            'currency' => 'JOD',
        ]);

        $premiumPlan = Plan::create([
            'tag' => 'premium',
            'name' => 'Premium Plan',
            'description' => 'For medium businesses',
            'price' => 100.00,
            'signup_fee' => 1.99,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 15,
            'trial_interval' => 'day',
            'grace_period' => 1,
            'grace_interval' => 'day',
            'tier' => 2,
            'currency' => 'JOD',
        ]);

        $enterprisePlan = Plan::create([
            'tag' => 'enterprise',
            'name' => 'Enterprise Plan',
            'description' => 'For large businesses',
            'price' => 200.00,
            'signup_fee' => 1.99,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 15,
            'trial_interval' => 'day',
            'grace_period' => 1,
            'grace_interval' => 'day',
            'tier' => 3,
            'currency' => 'JOD',
        ]);

        $basicPlan->features()->saveMany([
            new PlanFeature([
                'tag' => 'leads_management',
                'name' => 'Leads Management System (LMS) - 100k Leads',
                'description' => 'Leads Management System (LMS) - Control your leads and convert them to customers with our LMS system that allows you to manage your leads, assign them to your team, and track their progress.',
                'value' => 30,
                'sort_order' => 1,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'web_forms',
                'name' => 'Web Forms To Collect Leads - 5k Web Forms',
                'description' => 'Web Forms To Collect Leads - Collect leads from your website with our web forms that allow you to collect leads from your website and convert them to customers.',
                'value' => 30,
                'sort_order' => 2,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'agents_management',
                'name' => 'Agents Management System (AMS) - 10 Agents',
                'description' => 'Agents Management System (AMS) - Control all your agents and create teams with roles and permissions and give them access to the system.',
                'value' => 30,
                'sort_order' => 3,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'tasks_management',
                'name' => 'Tasks Management System (TMS) - 10K Tasks',
                'description' => 'Tasks Management System (TMS) - Control all your tasks and assign them to your team and track their progress.',
                'value' => 30,
                'sort_order' => 4,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'reports',
                'name' => 'Reports - 10 Reports',
                'description' => 'Reports - Get reports about your leads and customers with our reports system that allows you to get reports about your leads and customers.',
                'value' => 30,
                'sort_order' => 5,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

        ]);

        $premiumPlan->features()->saveMany([
            new PlanFeature([
                'tag' => 'leads_management',
                'name' => 'Leads Management System (LMS) - 500k Leads',
                'description' => 'Leads Management System (LMS) - Control your leads and convert them to customers with our LMS system that allows you to manage your leads, assign them to your team, and track their progress.',
                'value' => 50,
                'sort_order' => 1,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),
            new PlanFeature([
                'tag' => 'web_forms',
                'name' => 'Web Forms To Collect Leads - 50k Web Forms',
                'description' => 'Web Forms To Collect Leads - Collect leads from your website with our web forms that allow you to collect leads from your website and convert them to customers.',
                'value' => 50,
                'sort_order' => 2,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'agents_management',
                'name' => 'Agents Management System (AMS) - 25 Agents',
                'description' => 'Agents Management System (AMS) - Control all your agents and create teams with roles and permissions and give them access to the system.',
                'value' => 50,
                'sort_order' => 3,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'tasks_management',
                'name' => 'Tasks Management System (TMS) - 25K Tasks',
                'description' => 'Tasks Management System (TMS) - Control all your tasks and assign them to your team and track their progress.',
                'value' => 50,
                'sort_order' => 4,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'reports',
                'name' => 'Reports - 25 Reports',
                'description' => 'Reports - Get reports about your leads and customers with our reports system that allows you to get reports about your leads and customers.',
                'value' => 50,
                'sort_order' => 5,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

        ]);

        $enterprisePlan->features()->saveMany([
            new PlanFeature([
                'tag' => 'leads_management',
                'name' => 'Leads Management System (LMS) - 1M Leads',
                'description' => 'Leads Management System (LMS) - Control your leads and convert them to customers with our LMS system that allows you to manage your leads, assign them to your team, and track their progress.',
                'value' => 100,
                'sort_order' => 1,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),
            new PlanFeature([
                'tag' => 'web_forms',
                'name' => 'Web Forms To Collect Leads - 100k Web Forms',
                'description' => 'Web Forms To Collect Leads - Collect leads from your website with our web forms that allow you to collect leads from your website and convert them to customers.',
                'value' => 100,
                'sort_order' => 2,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'agents_management',
                'name' => 'Agents Management System (AMS) - 100 Agents',
                'description' => 'Agents Management System (AMS) - Control all your agents and create teams with roles and permissions and give them access to the system.',
                'value' => 100,
                'sort_order' => 3,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'tasks_management',
                'name' => 'Tasks Management System (TMS) - 100K Tasks',
                'description' => 'Tasks Management System (TMS) - Control all your tasks and assign them to your team and track their progress.',
                'value' => 100,
                'sort_order' => 4,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'email_marketing',
                'name' => 'Email Marketing - 1M Emails',
                'description' => 'Email Marketing - Send emails to your leads and customers with our email marketing system that allows you to send emails to your leads and customers.',
                'value' => 30,
                'sort_order' => 5,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'sms_marketing',
                'name' => 'SMSService Marketing - 1M SMSService',
                'description' => 'SMSService Marketing - Send SMSService to your leads and customers with our SMSService marketing system that allows you to send SMSService to your leads and customers.',
                'value' => 30,
                'sort_order' => 6,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'reports',
                'name' => 'Reports - 100 Reports',
                'description' => 'Reports - Get reports about your leads and customers with our reports system that allows you to get reports about your leads and customers.',
                'value' => 100,
                'sort_order' => 7,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),
            new PlanFeature([
                'tag' => 'internal_chat',
                'name' => 'Internal Chat - 50 Conversations',
                'description' => 'Internal Chat - Chat with your team and communicate with them with our internal chat system that allows you to chat with your team.',
                'value' => 30,
                'sort_order' => 8,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'Invoices_management_system',
                'name' => 'Invoices Management System (IMS) - 500k Invoices',
                'description' => 'Invoices Management System (IMS) - Control all your invoices and create invoices for your customers with our invoices management system that allows you to create invoices for your customers.',
                'value' => 30,
                'sort_order' => 9,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'payments_management_system',
                'name' => 'Payments Management System (PMS) - 1B Payments',
                'description' => 'Payments Management System (PMS) - Control all your payments and receive payments from your customers with our payments management system that allows you to receive payments from your customers.',
                'value' => 30,
                'sort_order' => 10,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

        ]);

        $freePlan->features()->saveMany([
            new PlanFeature([
                'tag' => 'leads_management',
                'name' => 'Leads Management System (LMS) - 100 Leads',
                'description' => 'Leads Management System (LMS) - Control your leads and convert them to customers with our LMS system that allows you to manage your leads, assign them to your team, and track their progress.',
                'value' => 10,
                'sort_order' => 1,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),
            new PlanFeature([
                'tag' => 'web_forms',
                'name' => 'Web Forms To Collect Leads - 10 Web Forms',
                'description' => 'Web Forms To Collect Leads - Collect leads from your website with our web forms that allow you to collect leads from your website and convert them to customers.',
                'value' => 10,
                'sort_order' => 2,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'agents_management',
                'name' => 'Agents Management System (AMS) - 10 Agents',
                'description' => 'Agents Management System (AMS) - Control all your agents and create teams with roles and permissions and give them access to the system.',
                'value' => 10,
                'sort_order' => 3,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),

            new PlanFeature([
                'tag' => 'tasks_management',
                'name' => 'Tasks Management System (TMS) - 10 Tasks',
                'description' => 'Tasks Management System (TMS) - Control all your tasks and assign them to your team and track their progress.',
                'value' => 10,
                'sort_order' => 4,
                'resettable_period' => 1,
                'resettable_interval' => 'month',
            ]),
        ]);

    }
}
