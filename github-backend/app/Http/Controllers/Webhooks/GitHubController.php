<?php

namespace App\Http\Controllers\Webhooks;

use App\Notifications\IssueCommentedNotification;
use App\Notifications\RepositoryPingNotification;
use App\Repository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class GitHubController extends Controller
{
    public function notify(Request $request)
    {

        if ($request->getMethod() == 'GET') {
            $user = User::find(1);
            $user->notify(new RepositoryPingNotification());
            return;
        }

        //ping notification
        if ($request->has('zen') && $request->has('hook') && $request->input('hook')['type'] == 'Repository') {

            $repositoryData = $request->input('repository');

            Repository::firstOrCreate(
                [
                    'repository_id' => $repositoryData['id']
                ],
                [
                    'name' => $repositoryData['name'],
                    'full_name' => $repositoryData['full_name'],
                    'description' => $repositoryData['description'],
                ]
            );

            $user = User::find(1);
            $user->notify(new RepositoryPingNotification());
        }


        //find repo in database if it exists
        if ($request->has('repository')) {
            $id = $request->input('repository')['id'];
            $repository = Repository::where('repository_id', $id)->first();
        }

        //comment created on issue
        if ($request->input('action', false) == 'created' && $request->has('issue') && $request->has('comment')) {

            $subscribers = [];
            
            foreach($repository->subscribers as $subscriber) {
                $subscribers[] = $subscriber->user;
            }

            Notification::send($subscribers, new IssueCommentedNotification($request->input('isssue'), $request->input('comment'), $request->input('repository')));

        }


    }
}
