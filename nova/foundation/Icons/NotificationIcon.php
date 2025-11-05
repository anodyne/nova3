<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

enum NotificationIcon: string
{
    case AlertCircle = 'neat-circle-exclamation';
    case AlertTriangle = 'neat-alert-triangle';
    case BookClosed = 'neat-book-1';
    case BookOpen = 'neat-book-open-2';
    case CheckCircle = 'neat-checked';
    case HelpCircle = 'neat-circle-question';
    case Inbox = 'neat-inbox';
    case InfoCircle = 'neat-info-circle-2';
    case Logout = 'neat-logout';
    case Megaphone = 'neat-megaphone-2';
    case ThumbsDown = 'neat-dislike-hand-2';
    case ThumbsUp = 'neat-like-hand-2';
    case UserAccount = 'neat-user-account-2';
    case UserCheck = 'neat-user-checked';
    case UserDelete = 'neat-user-delete';
    case UserMinus = 'neat-user-minus';
    case UserPlus = 'neat-user-add';
    case UserProfile = 'neat-user-avatar';
    case UserProfile2 = 'neat-user-story';
    case UserX = 'neat-user-remove';
    case XCircle = 'neat-x-circle';
}
