<?php

return [

    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は「バリデーションエラー文言」のデフォルトです。
    | 必要に応じてここを書き換えることでメッセージを日本語にできます。
    |
    */

    'accepted'             => ':attributeを承認してください。',
    'active_url'           => ':attributeは有効なURLではありません。',
    'after'                => ':attributeには:date以降の日付を指定してください。',
    'after_or_equal'       => ':attributeには:date以降もしくは同じ日付を指定してください。',
    'alpha'                => ':attributeはアルファベットのみ有効です。',
    'alpha_dash'           => ':attributeは英数字とダッシュ(-_)のみ有効です。',
    'alpha_num'            => ':attributeは英数字のみ有効です。',
    'array'                => ':attributeは配列である必要があります。',
    'before'               => ':attributeには:date以前の日付を指定してください。',
    'before_or_equal'      => ':attributeには:date以前もしくは同じ日付を指定してください。',
    'between'              => [
        'numeric' => ':attributeは:min〜:maxの間で指定してください。',
        'file'    => ':attributeは:min〜:max KBのファイルを指定してください。',
        'string'  => ':attributeは:min〜:max文字の間で指定してください。',
        'array'   => ':attributeの項目は:min〜:max個にしてください。',
    ],
    'boolean'              => ':attributeには true か false を指定してください。',
    'confirmed'            => ':attribute（確認用）と一致していません。',
    'date'                 => ':attributeは有効な日付ではありません。',
    'date_equals'          => ':attributeは:dateと同じ日付でなければいけません。',
    'date_format'          => ':attributeが:format形式と一致しません。',
    'different'            => ':attributeと:otherは異なる値を指定してください。',
    'digits'               => ':attributeは:digits桁で指定してください。',
    'digits_between'       => ':attributeは:min〜:max桁で指定してください。',
    'dimensions'           => ':attributeの画像サイズが無効です。',
    'distinct'             => ':attributeが重複しています。',
    'email'                => ':attributeの形式が無効です。',
    'exists'               => '選択された:attributeが正しくありません。',
    'file'                 => ':attributeはファイルを指定してください。',
    'filled'               => ':attributeに値を入力してください。',
    'gt' => [
        'numeric' => ':attributeは:valueより大きい値にしてください。',
        'file'    => ':attributeは:value KBより大きいファイルを指定してください。',
        'string'  => ':attributeは:value文字より多く入力してください。',
        'array'   => ':attributeは:value個より多く指定してください。',
    ],
    'gte' => [
        'numeric' => ':attributeは:value以上の値にしてください。',
        'file'    => ':attributeは:value KB以上のファイルにしてください。',
        'string'  => ':attributeは:value文字以上にしてください。',
        'array'   => ':attributeは:value個以上にしてください。',
    ],
    'image'                => ':attributeは画像（jpeg/pngなど）にしてください。',
    'in'                   => '選択された:attributeは無効です。',
    'in_array'             => ':attributeは:otherに存在しません。',
    'integer'              => ':attributeは整数を指定してください。',
    'ip'                   => ':attributeは有効なIPアドレスを指定してください。',
    'ipv4'                 => ':attributeは有効なIPv4アドレスを指定してください。',
    'ipv6'                 => ':attributeは有効なIPv6アドレスを指定してください。',
    'json'                 => ':attributeはJSON文字列で指定してください。',
    'lt' => [
        'numeric' => ':attributeは:valueより小さい値にしてください。',
        'file'    => ':attributeは:value KBより小さいファイルにしてください。',
        'string'  => ':attributeは:value文字より少なくしてください。',
        'array'   => ':attributeは:value個より少なくしてください。',
    ],
    'lte' => [
        'numeric' => ':attributeは:value以下の値にしてください。',
        'file'    => ':attributeは:value KB以下のファイルにしてください。',
        'string'  => ':attributeは:value文字以下にしてください。',
        'array'   => ':attributeは:value個以下にしてください。',
    ],
    'max' => [
        'numeric' => ':attributeは:max以下の値にしてください。',
        'file'    => ':attributeは:max KB以下のファイルにしてください。',
        'string'  => ':attributeは:max文字以下にしてください。',
        'array'   => ':attributeは:max個以下にしてください。',
    ],
    'mimes' => ':attributeは:valuesタイプのファイルにしてください。',
    'mimetypes' => ':attributeは:valuesタイプのファイルにしてください。',
    'min' => [
        'numeric' => ':attributeは:min以上にしてください。',
        'file'    => ':attributeは:min KB以上のファイルにしてください。',
        'string'  => ':attributeは:min文字以上にしてください。',
        'array'   => ':attributeは:min個以上にしてください。',
    ],
    'not_in'               => '選択された:attributeは無効です。',
    'not_regex'            => ':attributeの形式が正しくありません。',
    'numeric'              => ':attributeは数字を指定してください。',
    'password'             => 'パスワードが正しくありません。',
    'present'              => ':attributeは存在している必要があります。',
    'regex'                => ':attributeの形式が正しくありません。',
    'required'             => ':attributeを入力してください。',
    'required_if'          => ':attributeは:otherが:valueの場合必須です。',
    'required_unless'      => ':attributeは:otherが:valueでない限り必須です。',
    'required_with'        => ':attributeは:valuesがある場合必須です。',
    'required_with_all'    => ':attributeは:valuesがある場合必須です。',
    'required_without'     => ':attributeは:valuesがない場合必須です。',
    'required_without_all' => ':attributeは:valuesがない場合必須です。',
    'same'                 => ':attributeと:otherは同じにしてください。',
    'size' => [
        'numeric' => ':attributeは:sizeにしてください。',
        'file'    => ':attributeは:size KBのファイルにしてください。',
        'string'  => ':attributeは:size文字にしてください。',
        'array'   => ':attributeは:size個にしてください。',
    ],
    'string'               => ':attributeは文字列で指定してください。',
    'timezone'             => ':attributeは有効なタイムゾーンを指定してください。',
    'unique'               => ':attributeはすでに存在しています。',
    'uploaded'             => ':attributeのアップロードに失敗しました。',
    'url'                  => ':attributeは有効なURL形式で指定してください。',
    'attributes' => [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'name' => '名前',
        'address' => '住所',
        'postcode' => '郵便番号',
        'building' => '建物名',
    ],
];
