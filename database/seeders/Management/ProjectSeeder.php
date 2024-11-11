<?php

namespace Database\Seeders\Management;

use Illuminate\Database\Seeder;
use App\Models\Management\Project;
use Illuminate\Support\Facades\DB;
use App\Models\Management\ProjectFile;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project                           = new Project();
        $project->name                     = 'eCommerce Project';
        $project->client_id                = 1;
        $project->date                     = date('Y-m-d');
        $project->progress                 = 1;
        $project->billing_type             = 'hourly';
        $project->per_rate                 = 15;
        $project->total_rate               = 0;
        $project->estimated_hour           = 300;
        $project->status_id                = 26;
        $project->priority                 = 29;
        $project->description              = '<strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';
        $project->start_date               = date('Y-m-d');
        $project->end_date                 = date("Y-m-d", strtotime("+1 month", strtotime($project->start_date)));
        $project->amount                   = 4500.00;
        $project->due                      = 4500.00;
        $project->paid                     = 0;
        $project->notify_all_users         = 0;
        $project->notify_all_users_email   = 0;
        $project->company_id               = 2;
        $project->created_by               = 2;
        $project->invoice                  = 1;
        $project->save();

        //team members assign to project
        DB::table('project_membars')->insert([
            'project_id' => $project->id,
            'company_id' => 2,
            'user_id' => 4,
            'added_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // project discussions

        DB::table('discussions')->insert([
            'project_id' => $project->id,
            'company_id' => 2,
            'user_id' => 4,
            'subject' => 'Discussion 1',
            'description' => '<strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'show_to_customer' => 33,
            'last_activity' => date('Y-m-d H:i:s')
        ]);

        // discussions comments

        DB::table('discussion_comments')->insert([
            'discussion_id' => 1,
            'company_id' => 2,
            'user_id' => 4,
            'description' => '<strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'show_to_customer' => 33
        ]);

        DB::table('discussion_comments')->insert([
            'discussion_id' => 1,
            'company_id' => 2,
            'comment_id' => 1,
            'user_id' => 3,
            'description' => '<strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'show_to_customer' => 33
        ]);


        // project files
        $project_files = new ProjectFile();
        $project_files->company_id = 1;
        $project_files->project_id = $project->id;
        $project_files->subject = 'Demo File';
        $project_files->user_id = 3;
        $project_files->show_to_customer = 22;
        $project_files->last_activity = date('Y-m-d H:i:s');
        $project_files->save();

        // project comments
        DB::table('project_file_comments')->insert([
            'project_file_id' => 1,
            'company_id' => 2,
            'user_id' => 4,
            'description' => '<strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'show_to_customer' => 33
        ]);

        DB::table('project_file_comments')->insert([
            'project_file_id' => 1,
            'company_id' => 2,
            'comment_id' => 1,
            'user_id' => 3,
            'description' => '<strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'show_to_customer' => 33
        ]);

        // end project file
    }
}
