<?php

namespace App\Services;

use App\Issue;
use Exception;
use Illuminate\Support\Facades\Auth;

/**
 * Issue Service
 */
class IssueService
{
    public $attributes;
    private $issue;
    
    public function setIssue(Issue $issue)
    {
        $this->issue = $issue;
    }

    public function create()
    {
        $issue = new Issue();
        $issue->fill($this->attributes);
        $issue->author_user_id = Auth::id();

        $issue->save();
    }

    public function update()
    {
        $this->issue->fill($this->attributes);
        $this->issue->author_user_id = Auth::id();

        $this->issue->save();
    }
}
