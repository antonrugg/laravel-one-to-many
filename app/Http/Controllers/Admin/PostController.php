<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all(); //recuperiamo tutti i post
        return view('admin.posts.index', compact('posts'));
        //ritorno la view in admin/posts/index.blade.php e passo tutti i posts

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.posts.create');
        //ritorno la view in admin/posts/create
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
         $request->validate([
            'title' => 'required|max:250',
            'content' => 'required|min:5',
        ],
        [
            'title.required' =>'Titolo deve essere valorizzato.',
            'title.max' =>'Hai superato i 250 caratteri.',
            'content.required' => 'Il contenuto deve essere compilato.',
            'content.min' => 'Minimo 5 caratteri.'
            //modifichiamo il messaggio di errore standard
        ]);
        //validazione dati

        $postData = $request->all(); //prendiamo tutti i dati
        $newPost = new Post();//creiamo una nuova istanza di post
        $newPost->fill($postData);//filliamo newPost instance con i dati
        // $slug = Str::slug($newPost->title);//prendo il valore di titolo che potrebbe avere caratteri particolari e lo passiamo in slug per sistemarlo

        // dd($slug);//dump test per vedere lo slug prima
        // dd($alternativeSlug)

        // $alternativeSlug = $slug;//ci serve valorizzarlo uguale cosi' dopo il while possiamo avere il valore univoco corretto

        // $postFound = Post::where('slug', $slug)->first();
        //definiamo una variabile, usiamo post con static method where
        //se passiamo due parametri fa l'uguaglianza quindi se slug e' uguale al nostro slug
        //prendiamo solo il primo record con quello slug ->first()

        // $counter = 1;
        //mettiamo un numero in coda allo slug e lo facciamo partire da 1
        // while($postFound){//fintanto che postFound esiste (fintanto che un record e' uguale allo slug continuiamo a ciclare, pero' cambio lo slug da verificare)
            // $alternativeSlug = $slug . '_' . $counter;//definiamo una chiave che prende lo slug e ci aggiunge il counter
            // $counter++;//aumentiamo il contatore
            // $postFound = Post::where('slug', $alternativeSlug)->first();
            //definiamo una variabile con all'interno il primo slug uguale al nostro slug alternativo
        // }

        // $newPost->slug = $alternativeSlug;
        $newPost->slug = Post::convertToSlug($newPost->title);
        //funzione nel model Post

        $newPost->save();
        //salviamo il post

        return redirect()->route('admin.posts.index');
        //redirect alla route dove ci sono tutti i post
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        // $post = Post::findOrFail($id);
        if(!$post){
            abort(404);
        }
        //al post del findOrFail per provare
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::findOrFail($id);

        return view('admin.posts.edit', compact('post'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, Post $post)
    {
        //
        $request->validate([
            'title' => 'required|max:250',
            'content' => 'required|min:5',
        ],
        [
            'title.required' =>'Titolo deve essere valorizzato',
            'title.max' =>'Hai superato i 250 caratteri',
            'content.min' => 'Minimo 5 caratteri'
            //modifichiamo il messaggio di errore standard
        ]);
        //validazione dati

        // $post = Post::findOrFail($id);
        $postData = $request->all();

        $post->fill($postData);

        $post->slug = Post::convertToSlug($post->title);

        $post->update();

        return redirect()->route('admin.posts.index', compact('post'));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts.index', compact('post'));
    }
}
