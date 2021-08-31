# ナレッジベース

## Docker関連

- Docker関連

## Laravel関連

### コントローラ作成

- `php artisan make:controller SomethingController`
- `app/http/controllers/SomethingController.php`が生成される。

```php
public function getHome(){
    return view('home');
}
```

### ルーティング

- 先ほど作ったコントローラを使用できる状態にする(URLに関連付ける)
- `routes/web.php`
- `use App\Http\Controllers\SomethingController;`
- `Route::get('/path-to-page', [SomethingController::class, 'funcName']);`

### ページ内容

- bladeはテンプレートと説明されているブログがあるが、実際に使用してみると各ページで使いまわすための共通デザインテンプレートではなかった。

#### 課題

- 各ページで使いまわすための共通デザインテンプレートは別の場所にあると思われるので、**その機能を実現するための用語**を調べ、公式ドキュメントを**検索するための前提知識**が必要。

### ユーザ認証周り

- Laravel Breezeという公式ライブラリでよしなにやってくれる。

#### ユーザがログイン済みであるかの判定

    ```php
    use Illuminate\Support\Facades\Auth;

    if (Auth::check()) {
        // ユーザーはログイン済み
    }
    ```

#### ログイン中のユーザに関する情報を取得する

    ```php
    use Illuminate\Support\Facades\Auth;

    // 現在認証しているユーザーを取得
    $user = Auth::user();

    // 現在認証しているユーザーのIDを取得
    $id = Auth::id();
    ```

#### ログイン中のユーザだけがページにアクセスできるようにする

    - `routes/web.php`
    ```php
    Route::get('/path-to-members-only-page', function () {
        // 認証済みユーザーのみがこのルートにアクセス可能
    })->middleware('auth');
    ```

#### 非ログインユーザがメンバー専用ページにアクセスした際のリダイレクト先を指定する

- `app/Http/Middleware/Authenticate.php`

    ```php
    /**
     * ユーザーをリダイレクトするパスの取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        //ここに挙動を指定
        return route('login'); //ログインページへリダイレクト
    }
    ```

#### 特定のユーザだけがアクセスできるページを作る方法。

- roleカラムを作らず、`auth.php`内`guards: []`に`username`を明示的に指定することで実現可能。

#### ログアウト

```php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * ユーザーをアプリケーションからログアウトさせる
 *
 * @param  \Illuminate\Http\Request $request
 * @return \Illuminate\Http\Response
 */
public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
}
```

## PHP関連

- PHP関連

## 仕様策定全般

- UML（サーバの動作と人間の動きを表した図画）について知識を得る

## プログラミング全般

- SQLを恐れない。
- フレームワークが出来ることと出来ないことを理解する。
- JOINやGROUP-BYなど、必要に応じてSQL文を手書きすることも必要。
- 1つ1つ、順序だてて機能を実装する。
- DBへの接続で１単元、SELECT文で１単元、変数への格納で１単元、それを画面へ表示で１単元くらいに細かく分割してでも使い方をマスターする。
