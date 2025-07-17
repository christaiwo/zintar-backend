<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProposalController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Generate a response based on a prompt and predefined context.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'job' => 'required|string',
            'template' => 'required|string',
        ]);

        $myInfo = [
            'name' => 'Taiwo Ijagbemi',
            'bio' => '🎯 Turning Ideas into High-Performing Laravel & React Applications Looking for a reliable full-stack developer who builds more than just features? I help businesses architect secure, scalable, and production-ready platforms using Laravel, React, and modern tools like Tailwind CSS, Inertia.js, and Blade. Whether you’re developing a custom dashboard, building a multi-tenant SaaS, or integrating complex APIs — I turn complex challenges into clean, modular solutions.
                        🧰 How I Can Help
                        ✔️ Build secure, fast, and scalable Laravel applications from scratch
                        ✔️ Extend existing codebases and fix hard-to-track bugs in custom apps
                        ✔️ Create polished, responsive React or Blade admin dashboards
                        ✔️ Architect subscription billing, upgrade/downgrade logic, and pro-rated plans
                        ✔️ Set up multi-channel integrations (FTP, CSV, payment, email APIs)
                        ✔️ Integrate with IMAP, SMTP, OAuth, and inbox-related services
                        ✔️ Connect systems with REST APIs, webhooks, queues, and background jobs
                        ✔️ Optimize SQL queries, database schemas, and server performance
                        ✔️ Deploy Laravel apps with CI/CD pipelines and manage Linux/Unix hosting
                        ✔️ Implement role-based access, team permissions, and audit logging
                        ✔️ Handle full-stack features across Laravel, React, and TypeScript

                        🛠 Tools & Technologies

                        ⚙️ Backend & Frameworks
                        Laravel, PHP
                        FilamentPHP, Livewire, Inertia.js, Blade

                        🎨 Frontend
                        React, TypeScript, JavaScript
                        Tailwind CSS, Alpine.js

                        💾 Databases
                        MySQL, PostgreSQL, MongoDB, CassandraDB
                        Query optimization, data migrations, schema design

                        🔌 APIs & Integrations
                        REST APIs, Webhooks, Queue Systems
                        Stripe, PayPal, SendGrid, Firebase, Twilio
                        SMTP, IMAP, OAuth, seed list monitoring
                        Inbox integrations (Gmail, Outlook, Yahoo)

                        🚀 DevOps & Workflow
                        Git, GitHub Actions, GitLab CI
                        Docker (dev and production)
                        Linux/Unix server management

                        Agile tools: Trello, Jira, Asana

                        💡 Projects I Deliver
                        Multi-tenant SaaS platforms with secure billing logic
                        Email deliverability and inbox monitoring dashboards
                        Admin panels with role-based access & audit logs
                        CSV import/export tools, FTP automations, and seed list workflows
                        Custom eCommerce systems with pricing engines
                        Subscription portals with user control over renewals and billing
                        Data-rich dashboards with real-time analytics
                        Secure integrations with external APIs and webhook listeners

                        🗣 What Clients Say
                        “Great experience working with Taiwo! Understood our custom Laravel setup immediately and delivered clean, scalable code.”

                        “Fast delivery and deep knowledge of Laravel’s architecture. Taiwo resolved our complex subscription logic effortlessly.”

                        “Taiwo configured our asset system on time and beyond expectations. His Linux, Laravel, and admin panel skills were spot on.”

                        💼 Why Clients Hire Me
                        ✅ 4+ years of Laravel experience across real-world SaaS, eCommerce, and B2B platforms
                        ✅ Strong debugging skills in custom-built, legacy, or modular Laravel systems
                        ✅ Expert in full-stack development with Laravel backend and React/Blade frontend
                        ✅ Deep understanding of billing, email deliverability, and inbox logic
                        ✅ Communicates clearly, collaborates proactively, and always delivers
                        ✅ Available 35–50 hours/week — focused, fast, and flexible

                        📣 Let’s Build Something Powerful
                        Need someone to refactor legacy code, build a dashboard, or launch your next SaaS feature? I specialize in Laravel and React development that delivers real value — from MVP to production scale.

                        📩 Reach out now and let’s make it happen!

                        👋
                        Taiwo Ijagbemi
                        Laravel & React Full-Stack Developer
                    ',
            'skills' => [
                'Laravel',
                'PHP',
                'React',
                'TypeScript',
                'MySQL',
                'JavaScript',
                'API',
                'Tailwind CSS',
                'SQL',
                'MongoDB',
                'MySQL Programming',
                'API Development',
                'RESTful API',
                'Payment Gateway',
                'Website Migration',
            ],
            'projects' => [
                'SureBoosting – Social Media Boosting Platform: Built a Laravel-based SaaS platform that helps influencers and musicians grow their presence on platforms like Spotify. Developed secure, scalable backend services with PHP, MySQL, and REST APIs. Delivered a clean, responsive UI using HTML/CSS. Features include role-based access, email notifications (SMTP), and automated order handling. Focused on performance, modular architecture, and clean, maintainable code.',
                'RentDigit – Secure SaaS for Virtual Numbers: Built RentDigit.com, a secure, scalable SaaS for renting virtual numbers. Integrated multiple gateways (Flutterwave, Paystack, Squado, Etegram, Crypto) and built a clean, responsive UI with React and Tailwind CSS. Developed admin dashboard for full control over users, deposits, and settings. Used Laravel, PHP, and MySQL with a focus on maintainability, role-based access, and performance optimization.',
                'Laravel Event Booking SaaS for Church Conferences: Developed a scalable Laravel-based platform for global church events. Users can register, track attendance, and receive email confirmations. Built secure booking with role-based access, REST APIs, and responsive UI using HTML/CSS. Admins manage events with ease. Deployed on NGINX with optimized MySQL. Focused on clean, testable code, performance, and production-ready deployment.',
                'Scalable Hotel & POS Management SaaS – HeritageLuxuryHotel.com.ng: Built a Laravel-based hotel management platform with a full-featured POS system. Admins manage bookings, rooms, and guest communication via a secure, responsive dashboard. Developed with PHP, MySQL, JavaScript, and CSS. Focused on scalable architecture, clean code, and performance optimization. Designed to be modular, maintainable, and production-ready for hotel operations.',
            ],
        ];

        $generatedProposal = $this->geminiService->generateProposal($myInfo, $data['job'], $data['template']);

        // 4. Return the answer as JSON
        return response()->json([
            'answer' => $generatedProposal,
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
