<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    protected $table = 'product_review';
    protected $primaryKey = 'product_review_id';
    protected $fillable = ['account_id','product_id','content','rating','created_at','updated_at'];
    public $timestamps = true;

    public static function store($account_id,$product_id,$content,$rating)
    {
        return DB::table('product_review')->insert([
            'account_id' => $account_id,
            'product_id' => $product_id,
            'content' => $content,
            'rating' => $rating,
            'created_at' => now(),
        ]);
    }
    
    public static function destroy($id){
        return DB::table('product_review')->where('product_review_id', '=', $id)->delete();
    }

    public static function edit($id,$content,$rating){
        return DB::table('product_review')->where('product_review_id', $id)->update([
            'content' => $content,
            'rating' => $rating,
            'updated_at' => now()
        ]);
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function account(){
        return $this->belongsTo(Account::class,'account_id');
    }
}
