<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Faq extends Model
{

    protected $fillable = [
        'faq_id',
        'faq_title',
        'faq_content',
        'faq_sort_order',
        'create_at',
        'updated_at'
    ];

    protected $table = 'faq';

        static function imageUpload($content)
    {
        $dom = new \DomDocument();
        $dom->loadHtml('<?xml encoding="utf-8" ?>'.$content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $images = $dom->getElementsByTagName('img');
        foreach($images as $k => $img){
            $data = $img->getAttribute('src');
            if (!preg_match('/data:image/', $data)) {
                continue;
            }
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= "/images/uploads/" . time().$k.'.png';
            $path = public_path() . $image_name;
            file_put_contents($path, $data);
            $img->removeAttribute('src');
            $img->setAttribute('src', $image_name);
        }
        $content = $dom->saveHTML();
        return $content;
    }

}
