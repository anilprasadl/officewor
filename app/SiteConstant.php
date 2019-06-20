<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteConstant extends Model
{
      const MAIL_FROM = "noreply@devopsjmangroup.com";
      const MAIL_TO = "anilprasad@jmangroup.com";
      const SUBJECT_NOTIFICATION = "DevOps-Notification";
      const SUBJECT_ADMIN_NOTIFICATION = "DevOps-Slot-Book-Notification";
      const SUBJECT_REGISTRATION = "DevOps-Registration";
}