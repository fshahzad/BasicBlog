<?php

namespace App\Console\Commands;

use App\Mail\NewBlogPostsMail;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNewBlogPostsByEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-new-blog-posts-by-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = Post::where('email_sent', 0)->orderBy('id', 'DESC')->get();

        Mail::to( env('NOTIFICATION_EMAIL') )
                ->send(new NewBlogPostsMail($posts));

        Post::where('email_sent', 0)->update(['email_sent' => 1]);
    }
}
