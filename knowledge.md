# ナレッジベース

## Docker関連

- 環境構築はLaravel8.xから追加された機能`sail`が便利。phpの設定に悪戦苦闘しmysqlの設定に悪戦苦闘し…という事が無く、一発で完璧な環境が構築でき、本番環境としても十分実用的と思われる。
- docker for windowsの場合は、[microsoft storeのwsl store](https://aka.ms/wslstore)からWSL2用のUbuntuディストロを入れてDockerに設定しておくと使いやすい。
- readouble.comのLaravelドキュメントの日本語翻訳版を参考に、インストールスクリプトを実行してsail(docker-composeのラッパー)でupするだけ。

## Laravel関連

### HTTP 500エラーで何も表示されない場合

- .env が無い場合にエラーが出る

#### 課題

- .env でデータベースパスワードを定義すると接続エラーとなる。
~- mysql serverコンテナにパスワードの設定が反映していないため。
- docker execでmysqlコンテナに入り、手動でパスワード変更する必要があるのか、もしくはenvファイルを適用させる方法があるのか調査が必要。~
    - mysql完全に理解した。(Docker desktop のmysqlコンテナのログに書いてあった)
    - .envのDB_USERNAMEがrootのままだとエラーになる。
    - 任意のユーザーを記述することで期待した動作(データベースに接続できてテーブル作成やレコードの読み書きができる)になった。

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
- `use App\Http\Controllers\SomethingController;` ←これ大事。忘れるとclass not foundのエラーになる。
- `Route::get('/path-to-page', [SomethingController::class, 'funcName']);`
- 別の書き方
  ```php
  //コントローラを使わない方法
  function () {
      return view('hoge');
  });
  ```

  `Route::get('/path-to-page', 'somethingController@funcName');`


### ページ内容

~- bladeはテンプレートと説明されているブログがあるが、実際に使用してみると各ページで使いまわすための共通デザインテンプレートではなかった。~
- できる

#### 課題

- 各ページで使いまわすための共通デザインテンプレートは別の場所にあると思われる~ので、**その機能を実現するための用語**を調べ、公式ドキュメントを**検索するための前提知識**が必要。~
    - `@section`と`@yield`

### ユーザ認証周り

- `Laravel Breeze`という公式ライブラリでよしなにやってくれる。

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

    // 現在認証しているユーザーを取得 *ユーザーの全カラムが連想配列で取得されるので適宜必要なものを抜き出す*
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
