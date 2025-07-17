<?php

namespace App\Services;

use Exception;
use Gemini;

class GeminiService
{
    /**
     * The Gemini API client instance.
     *
     * @var \Gemini\Client
     */
    protected $client;

    public function __construct()
    {
        // It's good practice to ensure the API key exists before creating the client.
        $apiKey = config('services.ai.gemini.api_key');
        if (empty($apiKey)) {
            throw new Exception('Gemini API key is not configured. Please check your services.php config or .env file.');
        }
        $this->client = Gemini::client($apiKey);
    }

    /**
     * Generates a proposal by combining user info, a job description, and a template.
     *
     * @param  array  $userInfo  The user's professional information (bio, experience, projects).
     * @param  string  $jobDescription  The job description or specific request for the proposal.
     * @param  string  $template  The template for the desired output format.
     * @return string The generated proposal text.
     */
    public function generateProposal(array $userInfo, string $jobDescription, string $template): string
    {
        // 1. Build the context string from the user's information array.
        $userContext = $this->buildContextFromUserInfo($userInfo);

        // 2. Construct the final, detailed prompt for the AI.
        $fullPrompt = <<<PROMPT
                You are a professional upwork freelancer and expert proposal writer. Your task is to write a compelling and personalized proposal for a job application.

                Follow these instructions carefully:

                1.  **Adopt the Right Tone:** Write in a confident, professional, yet conversational and approachable manner. Avoid overly formal or robotic language. You want to sound like a capable and friendly expert, not a corporation.

                2.  **Understand the Candidate:** Use the "CANDIDATE INFORMATION" to grasp the candidate's skills, experience, and unique strengths.

                3.  **Analyze the Job:** Carefully review the "JOB DESCRIPTION" to understand the client's specific needs, pain points, and desired outcomes.

                4.  **Connect the Dots:** Your main task is to create a bridge between the candidate's background and the job's requirements. Clearly explain *how* the candidate's skills and projects make them the ideal fit for this specific job.

                5.  **Strict Template Adherence (Most Important Rule):** You ABSOLUTELY MUST format your response to fit EXACTLY within the "PROPOSAL TEMPLATE".
                    - Do NOT add any introductory text like "Here is the proposal:" or "Certainly, here is the generated text:".
                    - Do NOT add any concluding remarks or summaries.
                    - Your output must be ONLY the raw text that perfectly fills the template, and nothing else. The response should begin with the first word of the proposal and end with the last word.

                ---

                ### CANDIDATE INFORMATION:
                {$userContext}

                ---

                ### JOB DESCRIPTION:
                {$jobDescription}

                ---

                ### PROPOSAL TEMPLATE:
                {$template}
                PROMPT;
        try {
            $result = $this->client
                ->generativeModel('gemini-2.0-flash')
                ->generateContent($fullPrompt);

            return $result->text();
        } catch (Exception $e) {
            logger()->error('Gemini API Proposal Generation Error: '.$e->getMessage());

            return 'Sorry, there was an error generating the proposal. Please try again later.';
        }
    }

    /**
     * A private helper method to convert the user's info array into a readable string format for the AI.
     */
    private function buildContextFromUserInfo(array $userInfo): string
    {
        $context = "Name: {$userInfo['name']}\n\n";
        $context .= "### Bio\n{$userInfo['bio']}\n\n";

        if (! empty($userInfo['skills'])) {
            $context .= "### Skills \n";
            foreach ($userInfo['skills'] as $skill) {
                $context .= "- {$skill}\n";
            }
        }

        if (! empty($userInfo['projects'])) {
            $context .= "### Key Projects\n";
            foreach ($userInfo['projects'] as $project) {
                $context .= "- {$project}\n";
            }
        }

        return trim($context);
    }
}
