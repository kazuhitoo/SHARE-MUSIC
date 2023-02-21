<div class="header-items">
    <div class="header-logo">
        <img src="/img/logo.png">
    </div>
    <div class="header-titles">
        <div class="header-serch">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="serch" name="serch" id="serch-form" placeholder="キーワードをご入力ください">
        </div>
        <ul class="header-nav">
            @auth
            <li>{{ Auth::user()->name }}</li>
            @endauth
            @guest
            <li>ユーザ名</li>
            @endguest
            <li><a href="{{  route('post')  }}">投稿</a></li>
            <li><a href="{{  route('top')   }}">トップ</a></li>
            @auth
            <li><a href="{{  route('logout') }}">ログアウト</a></li>
            @endauth
            @guest
            <li><a href="{{  route('login') }}">ログイン</a></li>
            @endguest
        </ul>
    </div>
</div>