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



## PHP関連

- PHP関連
