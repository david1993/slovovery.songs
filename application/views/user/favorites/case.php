
<a  href="/user/favorites/">В избранном: <b><?=(Auth::instance()->logged_in('login')) ? $user->get_favorites_count():'0';?></b></a>
