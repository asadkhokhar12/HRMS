<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllContentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'company_id' => 1,
                'user_id' => 1,
                'type' => 'page',
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<p>Welcome to ONEST HRM! We are a dynamic and forward-thinking company dedicated to Serve best services. Established in 2013, we have been at the forefront of Software for 10+ years, serving all over the world</p>',
                'meta_title' => 'About Us',
                'meta_description' => null,
                'keywords' => 'about, us, about us',
                'status_id' => 1,
            ],
            [
                'id' => 2,
                'company_id' => 1,
                'user_id' => 1,
                'type' => 'page',
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '<p>We are here to assist you and provide the information you need. Please feel free to reach out to us using the following contact </p>',
                'meta_title' => 'Contact Us',
                'meta_description' => null,
                'keywords' => 'contact, us, contact us',
                'status_id' => 1,
            ],
            [
                'id' => 3,
                'company_id' => 1,
                'user_id' => 1,
                'type' => 'page',
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '
                <section>
                <h2>Information We Collect</h2>
                <p>We may collect personal information, usage data, and device details for various purposes.</p>
            </section>

            <section>
                <h2>How We Use Your Information</h2>
                <p>We use the collected information for providing and improving our services, communicating with you, analyzing user trends, and ensuring legal compliance and safety.</p>
            </section>

            <section>
                <h2>Sharing Your Information</h2>
                <p>We may share your data with service providers and for legal compliance.</p>
            </section>

            <section>
                <h2>Your Choices</h2>
                <p>You can opt-out of promotional communications and manage cookies through your browser settings.</p>
            </section>

            <section>
                <h2>Security</h2>
                <p>We take measures to protect your data, but no method is 100% secure.</p>
            </section>

            <section>
                <h2>Changes to this Privacy Policy</h2>
                <p>We may update this policy, and changes will be posted on this page.</p>
            </section>
                ',
                'meta_title' => 'Privacy Policy',
                'meta_description' => null,
                'keywords' => 'privacy, policy, privacy policy',
                'status_id' => 1,
            ],
            [
                'id' => 4,
                'company_id' => 1,
                'user_id' => 1,
                'type' => 'page',
                'title' => 'Support 24/7',
                'slug' => 'support-24-7',
                'content' => '
                <section>
    <h2>Support 24/7</h2>
    <p>We are here to assist you around the clock. If you have any questions, concerns, or need help with our products or services, please don\'t hesitate to reach out to our support team.</p>
</section>
                ',
                'meta_title' => 'Terms of Use',
                'meta_description' => null,
                'keywords' => 'supports, 24, 7, support 24/7',
                'status_id' => 1,
            ],
            [
                'id' => 5,
                'company_id' => 1,
                'user_id' => 1,
                'type' => 'page',
                'title' => 'Terms of Use',
                'slug' => 'terms-of-use',
                'content' => '
                <section>
                <h2>1. Acceptance of Terms</h2>
                <p>By using our services, you agree to be bound by these terms.</p>
            </section>

            <section>
                <h2>2. Use of Services</h2>
                <p>You may use our services only in accordance with these terms.</p>
            </section>

            <section>
                <h2>3. Intellectual Property</h2>
                <p>Our content and trademarks are protected by intellectual property laws.</p>
            </section>

            <section>
                <h2>4. Privacy Policy</h2>
                <p>Use of our services is also governed by our Privacy Policy.</p>
            </section>

            <section>
                <h2>5. Termination</h2>
                <p>We reserve the right to terminate or suspend your access to our services for violations of these terms.</p>
            </section>

            <section>
                <h2>6. Changes to Terms</h2>
                <p>We may update these terms, and changes will be posted on this page.</p>
            </section>
                ',
                'meta_title' => 'Terms of Use',
                'meta_description' => 'Terms of Use',
                'keywords' => 'terms, of, use, terms of use',
                'status_id' => 1,
            ],
            [
                'id' => 6,
                'company_id' => 1,
                'user_id' => 1,
                'type' => 'page',
                'title' => 'company Policies',
                'slug' => 'company-policies',
                'content' => '
                <section>
                <h2>1. Equal Opportunity Policy</h2>
                <p>Our company is an equal opportunity employer.</p>
            </section>

            <section>
                <h2>2. Code of Conduct</h2>
                <p>We expect all employees to adhere to our code of conduct.</p>
            </section>

            <section>
                <h2>3. Anti-Harassment Policy</h2>
                <p>We have a strict anti-harassment policy in place.</p>
            </section>

            <section>
                <h2>4. Data Privacy Policy</h2>
                <p>Protecting your data is a top priority for us.</p>
            </section>

            <section>
                <h2>5. Use of Company Resources</h2>
                <p>Guidelines for using company resources responsibly.</p>
            </section>

            <section>
                <h2>6. Termination and Resignation</h2>
                <p>Details about the process for termination and resignation.</p>
            </section>
                ',
                'meta_title' => 'company-policies',
                'meta_description' => 'Terms of Use',
                'keywords' => 'company-policies',
                'status_id' => 1,
            ],
            [
                'id' => 7,
                'company_id' => 1,
                'user_id' => 1,
                'type' => 'page',
                'title' => 'Refund Policy',
                'slug' => 'refund-policy',
                'content' => '

    <section>
    <h2>1. Refund Eligibility</h2>
    <p>We offer refunds under certain conditions. Please review our refund eligibility criteria.</p>
</section>

<section>
    <h2>2. Requesting a Refund</h2>
    <p>Details on how to request a refund, including contact information and required documentation.</p>
</section>

<section>
    <h2>3. Refund Processing</h2>
    <p>Information on the refund processing timeline and method of payment.</p>
</section>

<section>
    <h2>4. Non-Refundable Items</h2>
    <p>A list of items or services that are non-refundable.</p>
</section>

<section>
    <h2>5. Contact Us</h2>
    <p>If you have questions or need assistance with our refund policy, please don\'t hesitate to contact our support team.</p>
</section>
                ',
                'meta_title' => 'refund-policy',
                'meta_description' => 'Terms of Use',
                'keywords' => 'refund-policy',
                'status_id' => 1,
            ],
        ];

        DB::table('all_contents')->insert($data);
    }
}
