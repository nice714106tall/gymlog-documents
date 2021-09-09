# ban管理

ユーザからの報告により事実確認を行い、もしくは自主パトロールで違反行為を発見した場合、違反行為を行ったユーザーの一部機能を制限する。
また、非常に悪質な場合においては該当ユーザーをデータベースから抹消する。

BANするユーザーの情報を入力するフォーム

- input type=text(id) //UUIDを入力する
- textbox rows=5(reason) //ban理由を入力
- button(submit) //処理実行ボタン
- checkbox(all) //全機能を禁止する
- checkbox(sns) //SNS機能を禁止する

イベントリスナー

- textboxの内容が変化した時
  - textboxの内容が36文字である場合に、DBの`users`テーブルから該当UUIDを元に、`screenname`と`username`と`icon`を取得し、テキストボックスの右もしくは下に表示。
- submitボタンが押された時
  - 「`screenname`(`@username`)をbanしますが、よろしいですか？」のような確認ダイアログを表示し、肯定を意味するボタンが押されたら処理を進める
  - checkboxの内容はjson形式で`{'sns':true/false, 'all':true/false}`のようにする。
