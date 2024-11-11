<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Seeder;
use App\Helpers\CoreApp\Traits\PermissionTrait;
use App\Models\Permission\Permission;

class PermissionSeeder extends Seeder
{
    use PermissionTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->permissionData() ?? [] as $attribute => $keywords) {
            Permission::updateOrCreate([
                'attribute' => $attribute
            ], [
                'keywords' => json_encode($keywords),
                'created_at' =>now(),
                'updated_at' =>now()
            ]);
        }
    }


    protected function permissionData()
    {
        return [
            'hr_menu' => ['menu' => 'hr_menu'],
            'designations' => ['read' => 'designation_read', 'create' => 'designation_create', 'update' => 'designation_update', 'delete' => 'designation_delete'],
            'departments' => ['read' => 'department_read', 'create' => 'department_create', 'update' => 'department_update', 'delete' => 'department_delete'],
            'users' => [
                'read' => 'user_read', 'profile' => 'profile_view', 'create' => 'user_create', 'edit' => 'user_edit', 'user_permission' => 'user_permission',
                'update' => 'user_update', 'delete' => 'user_delete', 'registerFace' => 'registerFace', 'menu' => 'user_menu', 'make_hr' => 'make_hr', 'profile_image_view' => 'profile_image_view',
            ],
            'user_device' => ['list' => 'user_device_list', 'reset' => 'reset_device'],

            'profile' => [
                'attendance_profile' => 'attendance_profile', 'contract_profile' => 'contract_profile', 'phonebook_profile' => 'phonebook_profile', 'support_ticket_profile' => 'support_ticket_profile',
                'advance_profile' => 'advance_profile', 'commission_profile' => 'commission_profile', 'attendance_profile' => 'attendance_profile', 'appointment_profile' => 'appointment_profile',
                'visit_profile' => 'visit_profile', 'leave_request_profile' => 'leave_request_profile', 'notice_profile' => 'notice_profile',
                'salary_profile' => 'salary_profile', 'project_profile' => 'project_profile', 'task_profile' => 'task_profile', 'award_profile' => 'award_profile', 'travel_profile' => 'travel_profile',
            ],

            'roles' => ['read' => 'role_read', 'create' => 'role_create', 'update' => 'role_update', 'delete' => 'role_delete'],

            'branch' => ['read' => 'branch_read', 'create' => 'branch_create', 'update' => 'branch_update', 'delete' => 'branch_delete'],

            // leave module
            'leave_type' => ['read' => 'leave_type_read', 'create' => 'leave_type_create', 'update' => 'leave_type_update', 'delete' => 'leave_type_delete', 'menu' => 'leave_menu'],
            'leave_assign' => ['read' => 'leave_assign_read', 'create' => 'leave_assign_create', 'update' => 'leave_assign_update', 'delete' => 'leave_assign_delete'],
            'daily_leave' => ['read' => 'daily_leave_read'],
            'leave_request' => ['read' => 'leave_request_read', 'update' => 'leave_request_update', 'store' => 'leave_request_store', 'create' => 'leave_request_create', 'approve' => 'leave_request_approve', 'reject' => 'leave_request_reject', 'delete' => 'leave_request_delete'],

            // attendance
            'weekend' => ['read' => 'weekend_read', 'update' => 'weekend_update'],
            'holiday' => ['read' => 'holiday_read', 'create' => 'holiday_create', 'update' => 'holiday_update', 'delete' => 'holiday_delete'],
            'schedule' => ['read' => 'schedule_read', 'create' => 'schedule_create', 'update' => 'schedule_update', 'delete' => 'schedule_delete'],
            'attendance' => ['read' => 'attendance_read', 'create' => 'attendance_create', 'update' => 'attendance_update', 'delete' => 'attendance_delete', 'menu' => 'attendance_menu'],
            'shift' => ['read' => 'shift_read', 'create' => 'shift_create', 'update' => 'shift_update', 'delete' => 'shift_delete', 'menu' => 'shift_menu'],

            //payroll_menu
            'payroll' => [
                'menu' => 'payroll_menu',
                'payroll_item read' => 'list_payroll_item', 'payroll_item create' => 'create_payroll_item', 'payroll_item store' => 'store_payroll_item', 'payroll_item edit' => 'edit_payroll_item', 'payroll_item update' => 'update_payroll_item', 'payroll_item delete' => 'delete_payroll_item', 'payroll_item view' => 'view_payroll_item', 'payroll_item menu' => 'payroll_item_menu',
                'list_payroll_set ' => 'list_payroll_set', 'create_payroll_set' => 'create_payroll_set', 'store_payroll_set' => 'store_payroll_set', 'edit_payroll_set' => 'edit_payroll_set', 'update_payroll_set' => 'update_payroll_set', 'delete_payroll_set' => 'delete_payroll_set', 'view_payroll_set' => 'view_payroll_set', 'payroll_set_menu' => 'payroll_set_menu',
            ],

            //payslip module
            'payslip' => [
                'menu' => 'payslip_menu', 'salary_generate' => 'salary_generate', 'salary_view' => 'salary_view', 'salary_delete' => 'salary_delete', 'salary_edit' => 'salary_edit', 'salary_update' => 'salary_update', 'salary_payment' => 'salary_payment', 'payslip_list' => 'payslip_list',
            ],
            // announcements
            'announcement' => [

                'menu' => 'announcement_menu',
                'notice_menu' => 'notice_menu',
                'notice_list' => 'notice_list',
                'notice_edit' => 'notice_edit',
                'notice_update' => 'notice_update',
                'notice_create' => 'notice_create',
                'notice_delete' => 'notice_delete',
            ],

            //advance module
            'advance_type' => [
                'menu' => 'advance_type_menu', 'advance_type_create' => 'advance_type_create', 'advance_type_store' => 'advance_type_store', 'advance_type_edit' => 'advance_type_edit', 'advance_type_update' => 'advance_type_update', 'advance_type_delete' => 'advance_type_delete', 'advance_type_view' => 'advance_type_view',
                'advance_type_list' => 'advance_type_list',
            ],

            // advance_salaries
            'advance_pay' => [
                'menu' => 'advance_salaries_menu', 'advance_salaries_create' => 'advance_salaries_create', 'advance_salaries_store' => 'advance_salaries_store', 'advance_salaries_edit' => 'advance_salaries_edit', 'advance_salaries_update' => 'advance_salaries_update',
                'advance_salaries_delete' => 'advance_salaries_delete', 'advance_salaries_view' => 'advance_salaries_view', 'advance_salaries_approve' => 'advance_salaries_approve', 'advance_salaries_list' => 'advance_salaries_list',
                'advance_salaries_pay' => 'advance_salaries_pay', 'advance_salaries_invoice' => 'advance_salaries_invoice', 'advance_salaries_search' => 'advance_salaries_search',
            ],

            // salary module
            'salary' => [
                'menu' => 'salary_menu', 'salary_store' => 'salary_store', 'salary_edit' => 'salary_edit', 'salary_update' => 'salary_update', 'salary_delete' => 'salary_delete', 'salary_view' => 'salary_view',
                'salary_list' => 'salary_list', 'salary_pay' => 'salary_pay', 'salary_invoice' => 'salary_invoice', 'salary_approve' => 'salary_approve', 'salary_generate' => 'salary_generate', 'salary_calculate' => 'salary_calculate',
                'salary_search' => 'salary_search',
            ],

            // account module
            'account' => [
                'menu' => 'account_menu', 'account_create' => 'account_create', 'account_store' => 'account_store', 'account_edit' => 'account_edit', 'account_update' => 'account_update', 'account_delete' => 'account_delete',
                'account_view' => 'account_view', 'account_list' => 'account_list', 'account_search' => 'account_search',
            ],

            // deposit module
            'deposit' => [
                'menu' => 'deposit_menu', 'deposit_create' => 'deposit_create', 'deposit_store' => 'deposit_store', 'deposit_edit' => 'deposit_edit', 'deposit_update' => 'deposit_update', 'deposit_delete' => 'deposit_delete', 'deposit_list' => 'deposit_list',
            ],

            // expense module
            'expense' => [
                'menu' => 'expense_menu', 'expense_create' => 'expense_create', 'expense_store' => 'expense_store', 'expense_edit' => 'expense_edit', 'expense_update' => 'expense_update', 'expense_delete' => 'expense_delete', 'expense_list' => 'expense_list',
                'expense_approve' => 'expense_approve', 'expense_invoice' => 'expense_invoice', 'expense_pay' => 'expense_pay', 'expense_view' => 'expense_view',
            ],
            // deposit_category module
            'deposit_category' => [
                'menu' => 'deposit_category_menu', 'deposit_category_create' => 'deposit_category_create', 'deposit_category_store' => 'deposit_category_store', 'deposit_category_edit' => 'deposit_category_edit', 'deposit_category_update' => 'deposit_category_update', 'deposit_category_delete' => 'deposit_category_delete', 'deposit_category_list' => 'deposit_category_list',
            ],

            // payment_method module
            'payment_method' => [
                'menu' => 'payment_method_menu', 'payment_method_create' => 'payment_method_create', 'payment_method_store' => 'payment_method_store', 'payment_method_edit' => 'payment_method_edit', 'payment_method_update' => 'payment_method_update', 'payment_method_delete' => 'payment_method_delete', 'payment_method_list' => 'payment_method_list',
            ],

            // transaction module
            'transaction' => [
                'menu' => 'transaction_menu', 'transaction_create' => 'transaction_create', 'transaction_store' => 'transaction_store', 'transaction_edit' => 'transaction_edit', 'transaction_update' => 'transaction_update', 'transaction_delete' => 'transaction_delete', 'transaction_view' => 'transaction_view', 'transaction_list' => 'transaction_list',
            ],

            // project module
            'project' => [
                'menu' => 'project_menu', 'project_create' => 'project_create', 'project_store' => 'project_store', 'project_edit' => 'project_edit', 'project_update' => 'project_update', 'project_delete' => 'project_delete', 'project_view' => 'project_view', 'project_list' => 'project_list',
                'project_activity_view' => 'project_activity_view', 'project_member_view' => 'project_member_view', 'project_member_delete' => 'project_member_delete', 'project_complete' => 'project_complete', 'project_payment' => 'project_payment',
                'project_invoice_view' => 'project_invoice_view',
            ],

            // project_discussion module
            'project_discussion' => [
                'project_discussion_create' => 'project_discussion_create', 'project_discussion_store' => 'project_discussion_store', 'project_discussion_edit' => 'project_discussion_edit', 'project_discussion_update' => 'project_discussion_update',
                'project_discussion_delete' => 'project_discussion_delete', 'project_discussion_view' => 'project_discussion_view', 'project_discussion_list' => 'project_discussion_list', 'project_discussion_comment' => 'project_discussion_comment',
                'project_discussion_reply' => 'project_discussion_reply',
            ],

            // project_file module
            'project_file' => [
                'project_file_create' => 'project_file_create', 'project_file_store' => 'project_file_store', 'project_file_edit' => 'project_file_edit', 'project_file_update' => 'project_file_update', 'project_file_delete' => 'project_file_delete',
                'project_file_view' => 'project_file_view', 'project_file_list' => 'project_file_list', 'project_file_download' => 'project_file_download', 'project_file_comment' => 'project_file_comment', 'project_file_reply' => 'project_file_reply',
            ],

            // project_notes module

            'project_notes' => [
                'project_notes_create' => 'project_notes_create', 'project_notes_store' => 'project_notes_store', 'project_notes_edit' => 'project_notes_edit', 'project_notes_update' => 'project_notes_update', 'project_notes_delete' => 'project_notes_delete',
                'project_notes_list' => 'project_notes_list', 'project_files_comment' => 'project_files_comment',
            ],

            // general_settings

            'general_settings' => [
                'general_settings_read' => 'general_settings_read',
                'general_settings_update' => 'general_settings_update',
                'email_settings_update' => 'email_settings_update',
                'storage_settings_update' => 'storage_settings_update',

            ],

            // task module

            'task' => [
                'menu' => 'task_menu', 'task_create' => 'task_create', 'task_store' => 'task_store', 'task_edit' => 'task_edit', 'task_update' => 'task_update', 'task_delete' => 'task_delete', 'task_view' => 'task_view', 'task_list' => 'task_list',
                'task_activity_view' => 'task_activity_view', 'task_assign_view' => 'task_assign_view', 'task_assign_delete' => 'task_assign_delete', 'task_complete' => 'task_complete',
            ],

            //Client menu
            'client' => [
                'menu' => 'client_menu', 'client_create' => 'client_create', 'client_store' => 'client_store', 'client_edit' => 'client_edit', 'client_update' => 'client_update', 'client_delete' => 'client_delete', 'client_view' => 'client_view', 'client_list' => 'client_list',

            ],

            // task discussion
            'task_discussion' => [
                'task_discussion_create' => 'task_discussion_create', 'task_discussion_store' => 'task_discussion_store', 'task_discussion_edit' => 'task_discussion_edit', 'task_discussion_update' => 'task_discussion_update',
                'task_discussion_delete' => 'task_discussion_delete', 'task_discussion_view' => 'task_discussion_view', 'task_discussion_list' => 'task_discussion_list', 'task_discussion_comment' => 'task_discussion_comment',
                'task_discussion_reply' => 'task_discussion_reply',
            ],

            // task file
            'task_file' => [
                'task_file_create' => 'task_file_create', 'task_file_store' => 'task_file_store', 'task_file_edit' => 'task_file_edit', 'task_file_update' => 'task_file_update', 'task_file_delete' => 'task_file_delete',
                'task_file_view' => 'task_file_view', 'task_file_list' => 'task_file_list', 'task_file_download' => 'task_file_download', 'task_file_comment' => 'task_file_comment', 'task_file_reply' => 'task_file_reply',
            ],

            // task notes
            'task_notes' => [
                'task_notes_create' => 'task_notes_create', 'task_notes_store' => 'task_notes_store', 'task_notes_edit' => 'task_notes_edit', 'task_notes_update' => 'task_notes_update', 'task_notes_delete' => 'task_notes_delete',
                'task_notes_list' => 'task_notes_list', 'task_files_comment' => 'task_files_comment',
            ],

            // award type module
            'award_type' => [
                'menu' => 'award_type_menu', 'award_type_create' => 'award_type_create', 'award_type_store' => 'award_type_store', 'award_type_edit' => 'award_type_edit', 'award_type_update' => 'award_type_update',
                'award_type_delete' => 'award_type_delete', 'award_type_list' => 'award_type_list',
            ],

            // award module
            'award' => [
                'menu' => 'award_menu', 'award_create' => 'award_create', 'award_store' => 'award_store', 'award_edit' => 'award_edit', 'award_update' => 'award_update', 'award_delete' => 'award_delete',
                'award_view' => 'award_view', 'award_list' => 'award_list',
            ],

            // travel type module
            'travel_type' => [
                'menu' => 'travel_type_menu', 'travel_type_create' => 'travel_type_create', 'travel_type_store' => 'travel_type_store', 'travel_type_edit' => 'travel_type_edit', 'travel_type_update' => 'travel_type_update',
                'travel_type_delete' => 'travel_type_delete', 'travel_type_list' => 'travel_type_list',
            ],

            // travel module
            'travel' => [
                'menu' => 'travel_menu', 'travel_create' => 'travel_create', 'travel_store' => 'travel_store', 'travel_edit' => 'travel_edit', 'travel_update' => 'travel_update', 'travel_delete' => 'travel_delete',
                'travel_view' => 'travel_view', 'travel_list' => 'travel_list', 'travel_approve' => 'travel_approve', 'travel_payment' => 'travel_payment',
            ],
            // meeting module
            'meeting' => [
                'menu' => 'meeting_menu',
                'meeting_create' => 'meeting_create',
                'meeting_store' => 'meeting_store',
                'meeting_edit' => 'meeting_edit',
                'meeting_update' => 'meeting_update',
                'meeting_delete' => 'meeting_delete',
                'meeting_view' => 'meeting_view',
                'meeting_list' => 'meeting_list',
            ],

            'appointment' => [

                'appointment_menu' => 'appointment_menu',
                'appointment_read' => 'appointment_read',
                'appointment_create' => 'appointment_create',
                'appointment_approve' => 'appointment_approve',
                'appointment_reject' => 'appointment_reject',
                'appointment_delete' => 'appointment_delete',
            ],

            // performance module
            'performance' => ['menu' => 'performance_menu', 'settings' => 'performance_settings'],

            // performance_indicator module
            'performance_indicator' => [
                'menu' => 'performance_indicator_menu', 'performance_indicator_create' => 'performance_indicator_create', 'performance_indicator_store' => 'performance_indicator_store', 'performance_indicator_edit' => 'performance_indicator_edit', 'performance_indicator_update' => 'performance_indicator_update',
                'performance_indicator_delete' => 'performance_indicator_delete', 'performance_indicator_list' => 'performance_indicator_list', 'performance_indicator_view' => 'performance_indicator_view',
            ],

            //performance_appraisal module
            'performance_appraisal' => [
                'menu' => 'performance_appraisal_menu', 'performance_appraisal_create' => 'performance_appraisal_create', 'performance_appraisal_store' => 'performance_appraisal_store', 'performance_appraisal_edit' => 'performance_appraisal_edit', 'performance_appraisal_update' => 'performance_appraisal_update',
                'performance_appraisal_delete' => 'performance_appraisal_delete', 'performance_appraisal_list' => 'performance_appraisal_list', 'performance_appraisal_view' => 'performance_appraisal_view',
            ],

            // performance_goal_type module
            'performance_goal_type' => [
                'menu' => 'performance_goal_type_menu', 'performance_goal_type_create' => 'performance_goal_type_create', 'performance_goal_type_store' => 'performance_goal_type_store', 'performance_goal_type_edit' => 'performance_goal_type_edit', 'performance_goal_type_update' => 'performance_goal_type_update',
                'performance_goal_type_delete' => 'performance_goal_type_delete', 'performance_goal_type_list' => 'performance_goal_type_list',
            ],

            // performance_goal module
            'performance_goal' => [
                'menu' => 'performance_goal_menu', 'performance_goal_create' => 'performance_goal_create', 'performance_goal_store' => 'performance_goal_store', 'performance_goal_edit' => 'performance_goal_edit', 'performance_goal_update' => 'performance_goal_update', 'performance_goal_delete' => 'performance_goal_delete',
                'performance_goal_view' => 'performance_goal_view', 'performance_goal_list' => 'performance_goal_list',
            ],

            // performance_competence_type module
            'performance_competence_type' => [
                'menu' => 'performance_competence_type_menu', 'performance_competence_type_create' => 'performance_competence_type_create', 'performance_competence_type_store' => 'performance_competence_type_store', 'performance_competence_type_edit' => 'performance_competence_type_edit', 'performance_competence_type_update' => 'performance_competence_type_update',
                'performance_competence_type_delete' => 'performance_competence_type_delete', 'performance_competence_type_list' => 'performance_competence_type_list',
            ],
            // performance_competence module
            'performance_competence' => [
                'menu' => 'performance_competence_menu', 'performance_competence_create' => 'performance_competence_create', 'performance_competence_store' => 'performance_competence_store', 'performance_competence_edit' => 'performance_competence_edit', 'performance_competence_update' => 'performance_competence_update',
                'performance_competence_delete' => 'performance_competence_delete', 'performance_competence_list' => 'performance_competence_list',
            ],

            //report
            'report' => ['attendance_report' => 'attendance_report_read', 'live_tracking_read' => 'live_tracking_read', 'menu' => 'report_menu'],
            // settings

            'leave_settings' => ['read' => 'leave_settings_read', 'update' => 'leave_settings_update'],
            'ip' => ['read' => 'ip_read', 'create' => 'ip_create', 'update' => 'ip_update', 'delete' => 'ip_delete'],

            'company_setup' => [
                'menu' => 'company_setup_menu', 'activation_read' => 'company_setup_activation', 'activation_update' => 'company_setup_activation_update', 'configuration_read' => 'company_setup_configuration',
                'configuration_update' => 'company_setup_configuration_update',
                'location_read' => 'company_setup_location', 'company_update' => 'company_settings_update',
            ],
            'location' => [
                'location_create' => 'location_create', 'location_store' => 'location_store', 'location_edit' => 'location_edit', 'location_update' => 'location_update', 'location_delete' => 'location_delete',
            ],

            'api_setup' => ['read' => 'locationApi'],

            'claim' => ['read' => 'claim_read', 'create' => 'claim_create', 'update' => 'claim_update', 'delete' => 'claim_delete'],
            'payment' => ['read' => 'payment_read', 'create' => 'payment_create', 'update' => 'payment_update', 'delete' => 'payment_delete'],

            //visit
            'visit' => ['menu' => 'visit_menu', 'read' => 'visit_read', 'update' => 'visit_update', 'view' => 'visit_view'],

            // for saas or non saas

            //app settings
            'app_settings' => ['menu' => 'app_settings_menu', 'update' => 'app_settings_update'],

            // web setup
            'web_setup' => ['menu' => 'web_setup_menu'],

            //content
            'content' => ['menu' => 'content_menu', 'read' => 'content_read', 'update' => 'content_update', 'delete' => 'content_delete'],

            //menu
            'menu' => ['menu' => 'menu', 'create' => 'menu_create', 'menu_store' => 'menu_store', 'menu_edit' => 'menu_edit', 'update' => 'menu_update', 'delete' => 'menu_delete'],
            // service
            'service' => ['menu' => 'service_menu', 'read' => 'service_read', 'create' => 'service_create', 'update' => 'service_update', 'delete' => 'service_delete'],

            //portfolio
            'portfolio' => ['menu' => 'portfolio_menu', 'create' => 'portfolio_create', 'portfolio_store' => 'portfolio_store', 'edit' => 'portfolio_edit', 'update' => 'portfolio_update', 'delete' => 'portfolio_delete'],
            // team member
            'contact' => ['menu' => 'contact_menu', 'read' => 'contact_read', 'create' => 'contact_create', 'update' => 'contact_update', 'delete' => 'contact_delete'],

            'language' => ['menu' => 'language_menu', 'create' => 'language_create', 'edit' => 'language_edit', 'update' => 'language_update', 'delete' => 'language_delete', 'make_default' => 'make_default', 'setup_language' => 'setup_language'],

            //contact
            'team_member' => ['menu' => 'team_member_menu', 'read' => 'team_member_read', 'create' => 'team_member_create', 'team_member_store' => 'team_member_store', 'team_member_edit' => 'team_member_edit', 'update' => 'team_member_update', 'delete' => 'team_member_delete'],

            //support
            'support' => [
                'support_menu' => 'support_menu',
                'support_read' => 'support_read',
                'support_create' => 'support_create',
                'support_reply' => 'support_reply',
                'support_delete' => 'support_delete',
            ],


            // 2024-01-09 START
            'model' => ['read' => 'model_read', 'create' => 'model_create', 'update' => 'model_update', 'delete' => 'model_delete'],
            'brand' => ['read' => 'brand_read', 'create' => 'brand_create', 'update' => 'brand_update', 'delete' => 'brand_delete'],
            'machine' => ['read' => 'machine_read', 'create' => 'machine_create', 'update' => 'machine_update', 'delete' => 'machine_delete'],
            'package' => ['read' => 'package_read', 'create' => 'package_create', 'update' => 'package_update', 'delete' => 'package_delete'],
            'institution' => ['read' => 'institution_read', 'create' => 'institution_create', 'update' => 'institution_update', 'delete' => 'institution_delete'],
            'addons_menu' => ['menu' => 'addons_menu'],
            'employee_document_type' => ['read' => 'employee_document_type_read', 'create' => 'employee_document_type_create', 'update' => 'employee_document_type_update', 'delete' => 'employee_document_type_delete'],
            'employee_document' => ['read' => 'employee_document_read', 'create' => 'employee_document_create', 'download' => 'employee_document_download'],
            // 2024-01-09 END

            // 2024-01-10 START
            'subscription' => ['read' => 'subscription_read', 'upgrade' => 'subscription_upgrade', 'invoice' => 'subscription_invoice'],
            // 2024-01-10 END
        ];
    }
}
