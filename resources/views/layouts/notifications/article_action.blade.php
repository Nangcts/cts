<a href="{{route('allRoute',$notification->data['article']['slug'])}}">
    <strong>{{$notification->data['user']['name']}}</strong> đã viết bài <strong> {{ strim_intro($notification->data['article']['title'], 125) }}</strong> <br>
    <?php \Carbon\Carbon::setLocale('vi'); ?>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['article']['created_at'])->diffForHumans() }}</span>
</a>