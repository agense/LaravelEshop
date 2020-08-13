<?php
namespace App\Services;

use App\Exceptions\ModelModificationException;
use App\Services\EditorContentProcessor;
use Illuminate\Support\Facades\Input;
use App\Models\Page;


class PageService {

    private $editor;
    private $pagination = 10;

    /**
     * Inject EditorContentProcessor Service
     */
    public function __construct(EditorContentProcessor $contentEditor)
    {   
        $this->editor = $contentEditor;
    }

    /**
     * Return a paginated listing of all pages
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return Page::orderBy('created_at', 'DESC')->paginate($this->pagination);
    }

    /**
     * Get single page by slug
     * @param String $slug
     * @return App\Models\Page
     */
    public function getOneBySlug(String $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        $page->content = $this->editor->decodeContent($page->content);
        return $page;
    }

    /**
     * Creates new page or updates existing one
     * @param App\Models\Page $page (optional)
     * @return App\Models\Page
     */
    public function savePage($page = null){
        try{
            $page = $page instanceof Page ? $page : new Page;
            $page->fill(request()->only('title','type'));
            $page->content = $this->editor->processContent(request()->content);
            $page->save();
            return $page;
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

    /**
     * Delete page from database
     * @param App\Models\Page $page 
     * @return Void
     */
    public function delete(Page $page){
        try{ 
            $this->editor->deleteAllImages($page->content);
            $page->delete();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

    /**
     * Deletes a content image from storage
     * @return Void
     */
    public function deleteContentImage(){
        if(!$this->editor->deleteEditorImage(request()->fileurl)){
            abort(422, 'Image delete failed');
        } 
    }

}