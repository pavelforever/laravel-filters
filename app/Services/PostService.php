<?php 

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostService
{
    public function createPost($data){
        try {
            DB::beginTransaction();

            $tags = [];

            if (array_key_exists('tag_ids', $data)) {
                $tags = $data['tag_ids'];
                unset($data['tag_ids']);
            }

            $data['image'] = Storage::disk('public')->put('images', $data['image']);
            $previewImagePath = Storage::disk('public')->put('images', $data['imagePreview']);
            
            $imagePreview = Image::make(storage_path('app/public/'.$previewImagePath));
            $imagePreview->fit(600, 360);
            $imagePreview->save();

            $data['imagePreview'] = $previewImagePath;

            $post = Post::create($data);

            $post->tags()->attach($tags);

            DB::commit();

            return $post;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
    public function updatePost(Post $post, $data)
    {
        try {
            DB::beginTransaction();

            $tagIds = [];

            if (array_key_exists('tag_ids', $data)) {
                $tagIds = $data['tag_ids'];
                unset($data['tag_ids']);
                $post->tags()->sync($tagIds);
            } else {
                $post->tags()->detach();
            }

            if ($data['image']) {
                Storage::disk('public')->delete($post->image);
                $data['image'] = Storage::disk('public')->put('images', $data['image']);
            }

            if ($data['previewImage']) {
                Storage::disk('public')->delete($post->imagePreview);
                $previewImagePath = Storage::disk('public')->put('images', $data['previewImage']);

                $previewImage = Image::make(storage_path('app/public/'.$previewImagePath));
                $previewImage->fit(600, 360);
                $previewImage->save();

                $data['imagePreview'] = $previewImagePath;
            }

            $post->update($data);

            DB::commit();

            return $post;
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }
}