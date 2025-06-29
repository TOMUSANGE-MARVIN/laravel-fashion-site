<?php
/* */

return [
    'accepted'        => ':attribute alanı kabul edilmelidir.',
    'accepted_if'     => ':attribute alanı, :other :value olduğunda kabul edilmelidir.',
    'active_url'      => ':attribute alanı geçerli bir URL olmalıdır.',
    'after'           => ':attribute alanı, :date tarihinden sonra bir tarih olmalıdır.',
    'after_or_equal'  => ':attribute alanı, :date tarihinden sonra veya ona eşit bir tarih olmalıdır.',
    'alpha'           => ':attribute alanı yalnızca harfler içermelidir.',
    'alpha_dash'      => ':attribute alanı yalnızca harfler, sayılar, tireler ve alt çizgiler içermelidir.',
    'alpha_num'       => ':attribute alanı yalnızca harfler ve sayılar içermelidir.',
    'array'           => ':attribute alanı bir dizi olmalıdır.',
    'ascii'           => ':attribute alanı yalnızca tek baytlık alfasayısal karakterler ve semboller içermelidir.',
    'before'          => ':attribute alanı, :date tarihinden önce bir tarih olmalıdır.',
    'before_or_equal' => ':attribute alanı, :date tarihinden önce veya ona eşit bir tarih olmalıdır.',
    'between'         => [
        'array'   => ':attribute alanı, :min ve :max arasında öğe içermelidir.',
        'file'    => ':attribute alanı, :min ve :max kilobayt arasında olmalıdır.',
        'numeric' => ':attribute alanı, :min ve :max arasında olmalıdır.',
        'string'  => ':attribute alanı, :min ve :max karakter arasında olmalıdır.',
    ],
    'boolean'           => ':attribute alanı doğru veya yanlış olmalıdır.',
    'can'               => ':attribute alanı yetkisiz bir değer içeriyor.',
    'confirmed'         => ':attribute alanı onayı eşleşmiyor.',
    'current_password'  => 'Şifre yanlış.',
    'date'              => ':attribute alanı geçerli bir tarih olmalıdır.',
    'date_equals'       => ':attribute alanı, :date tarihine eşit bir tarih olmalıdır.',
    'date_format'       => ':attribute alanı, :format formatına uymalıdır.',
    'decimal'           => ':attribute alanı, :decimal ondalıklı basamağa sahip olmalıdır.',
    'declined'          => ':attribute alanı reddedilmelidir.',
    'declined_if'       => ':attribute alanı, :other :value olduğunda reddedilmelidir.',
    'different'         => ':attribute alanı ve :other farklı olmalıdır.',
    'digits'            => ':attribute alanı, :digits basamağa sahip olmalıdır.',
    'digits_between'    => ':attribute alanı, :min ve :max basamak arasında olmalıdır.',
    'dimensions'        => ':attribute alanının geçersiz resim boyutları vardır.',
    'distinct'          => ':attribute alanında tekrar eden bir değer bulunmaktadır.',
    'doesnt_end_with'   => ':attribute alanı şu değerlerle bitmemelidir: :values.',
    'doesnt_start_with' => ':attribute alanı şu değerlerle başlamamalıdır: :values.',
    'email'             => ':attribute alanı geçerli bir e-posta adresi olmalıdır.',
    'ends_with'         => ':attribute alanı şu değerlerle bitmelidir: :values.',
    'enum'              => 'Seçilen :attribute geçersiz.',
    'exists'            => 'Seçilen :attribute geçersiz.',
    'extensions'        => ':attribute alanı şu uzantılardan birine sahip olmalıdır: :values.',
    'file'              => ':attribute alanı bir dosya olmalıdır.',
    'filled'            => ':attribute alanının bir değeri olmalıdır.',
    'gt'                => [
        'array'   => ':attribute alanı, :value öğeden fazla olmalıdır.',
        'file'    => ':attribute alanı, :value kilobayttan büyük olmalıdır.',
        'numeric' => ':attribute alanı, :value değerinden büyük olmalıdır.',
        'string'  => ':attribute alanı, :value karakterden fazla olmalıdır.',
    ],
    'gte' => [
        'array'   => ':attribute alanı, :value öğe veya daha fazla olmalıdır.',
        'file'    => ':attribute alanı, :value kilobayttan büyük veya ona eşit olmalıdır.',
        'numeric' => ':attribute alanı, :value değerinden büyük veya ona eşit olmalıdır.',
        'string'  => ':attribute alanı, :value karakterden büyük veya ona eşit olmalıdır.',
    ],
    'hex_color' => ':attribute alanı geçerli bir onaltılık renk olmalıdır.',
    'image'     => ':attribute alanı bir resim olmalıdır.',
    'in'        => 'Seçilen :attribute geçersiz.',
    'in_array'  => ':attribute alanı, :other içinde bulunmalıdır.',
    'integer'   => ':attribute alanı bir tam sayı olmalıdır.',
    'ip'        => ':attribute alanı geçerli bir IP adresi olmalıdır.',
    'ipv4'      => ':attribute alanı geçerli bir IPv4 adresi olmalıdır.',
    'ipv6'      => ':attribute alanı geçerli bir IPv6 adresi olmalıdır.',
    'json'      => ':attribute alanı geçerli bir JSON dizesi olmalıdır.',
    'list'      => ':attribute alanı bir liste olmalıdır.',
    'lowercase' => ':attribute alanı küçük harf olmalıdır.',
    'lt'        => [
        'array'   => ':attribute alanı, :value öğeden az olmalıdır.',
        'file'    => ':attribute alanı, :value kilobayttan küçük olmalıdır.',
        'numeric' => ':attribute alanı, :value değerinden küçük olmalıdır.',
        'string'  => ':attribute alanı, :value karakterden az olmalıdır.',
    ],
    'lte' => [
        'array'   => ':attribute alanı, :value öğeden fazla olmamalıdır.',
        'file'    => ':attribute alanı, :value kilobayttan küçük veya ona eşit olmalıdır.',
        'numeric' => ':attribute alanı, :value değerinden küçük veya ona eşit olmalıdır.',
        'string'  => ':attribute alanı, :value karakterden küçük veya ona eşit olmalıdır.',
    ],
    'mac_address' => ':attribute alanı geçerli bir MAC adresi olmalıdır.',
    'max'         => [
        'array'   => ':attribute alanı, :max öğeden fazla olmamalıdır.',
        'file'    => ':attribute alanı, :max kilobayttan büyük olmamalıdır.',
        'numeric' => ':attribute alanı, :max değerinden büyük olmamalıdır.',
        'string'  => ':attribute alanı, :max karakterden büyük olmamalıdır.',
    ],
    'max_digits' => ':attribute alanı, :max basamaktan fazla olmamalıdır.',
    'mimes'      => ':attribute alanı, şu türde bir dosya olmalıdır: :values.',
    'mimetypes'  => ':attribute alanı, şu türde bir dosya olmalıdır: :values.',
    'min'        => [
        'array'   => ':attribute alanı, en az :min öğe içermelidir.',
        'file'    => ':attribute alanı, en az :min kilobayt olmalıdır.',
        'numeric' => ':attribute alanı, en az :min olmalıdır.',
        'string'  => ':attribute alanı, en az :min karakter olmalıdır.',
    ],
    'min_digits'       => ':attribute alanı, en az :min basamağa sahip olmalıdır.',
    'missing'          => ':attribute alanı eksik olmalıdır.',
    'missing_if'       => ':attribute alanı, :other :value olduğunda eksik olmalıdır.',
    'missing_unless'   => ':attribute alanı, :other :value olmadığı sürece eksik olmalıdır.',
    'missing_with'     => ':attribute alanı, :values mevcut olduğunda eksik olmalıdır.',
    'missing_with_all' => ':attribute alanı, :values mevcut olduğunda eksik olmalıdır.',
    'multiple_of'      => ':attribute alanı, :value\'nin katı olmalıdır.',
    'not_in'           => 'Seçilen :attribute geçersiz.',
    'not_regex'        => ':attribute alanı formatı geçersiz.',
    'numeric'          => ':attribute alanı bir sayı olmalıdır.',
    'password'         => [
        'letters'       => ':attribute alanı en az bir harf içermelidir.',
        'mixed'         => ':attribute alanı en az bir büyük harf ve bir küçük harf içermelidir.',
        'numbers'       => ':attribute alanı en az bir rakam içermelidir.',
        'symbols'       => ':attribute alanı en az bir sembol içermelidir.',
        'uncompromised' => 'Verilen :attribute bir veri sızıntısında göründü. Lütfen farklı bir :attribute seçin.',
    ],
    'present'              => ':attribute alanı mevcut olmalıdır.',
    'present_if'           => ':attribute alanı, :other :value olduğunda mevcut olmalıdır.',
    'present_unless'       => ':attribute alanı, :other :value olmadığı sürece mevcut olmalıdır.',
    'present_with'         => ':attribute alanı, :values mevcut olduğunda mevcut olmalıdır.',
    'present_with_all'     => ':attribute alanı, :values mevcut olduğunda mevcut olmalıdır.',
    'prohibited'           => ':attribute alanı yasaktır.',
    'prohibited_if'        => ':attribute alanı, :other :value olduğunda yasaktır.',
    'prohibited_unless'    => ':attribute alanı, :other :values içinde olduğu sürece yasaktır.',
    'prohibits'            => ':attribute alanı, :other\'in mevcut olmasını yasaklar.',
    'regex'                => ':attribute alanı formatı geçersiz.',
    'required'             => ':attribute alanı gereklidir.',
    'required_array_keys'  => ':attribute alanı, şu öğelere sahip olmalıdır: :values.',
    'required_if'          => ':attribute alanı, :other :value olduğunda gereklidir.',
    'required_if_accepted' => ':attribute alanı, :other kabul edildiğinde gereklidir.',
    'required_if_declined' => ':attribute alanı, :other reddedildiğinde gereklidir.',
    'required_unless'      => ':attribute alanı, :other :values içinde olmadığı sürece gereklidir.',
    'required_with'        => ':attribute alanı, :values mevcut olduğunda gereklidir.',
    'required_with_all'    => ':attribute alanı, :values mevcut olduğunda gereklidir.',
    'required_without'     => ':attribute alanı, :values mevcut olmadığında gereklidir.',
    'required_without_all' => ':attribute alanı, :values hiçbiri mevcut olmadığında gereklidir.',
    'same'                 => ':attribute alanı, :other ile eşleşmelidir.',
    'size'                 => [
        'array'   => ':attribute alanı, :size öğe içermelidir.',
        'file'    => ':attribute alanı, :size kilobayt olmalıdır.',
        'numeric' => ':attribute alanı, :size olmalıdır.',
        'string'  => ':attribute alanı, :size karakter olmalıdır.',
    ],
    'starts_with' => ':attribute alanı şu değerlerle başlamalıdır: :values.',
    'string'      => ':attribute alanı bir dize olmalıdır.',
    'timezone'    => ':attribute alanı geçerli bir zaman dilimi olmalıdır.',
    'unique'      => ':attribute zaten alınmış.',
    'uploaded'    => ':attribute yükleme başarısız oldu.',
    'uppercase'   => ':attribute alanı büyük harf olmalıdır.',
    'url'         => ':attribute alanı geçerli bir URL olmalıdır.',
    'ulid'        => ':attribute alanı geçerli bir ULID olmalıdır.',
    'uuid'        => ':attribute alanı geçerli bir UUID olmalıdır.',

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    'attributes' => [],
];
