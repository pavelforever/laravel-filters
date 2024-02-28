{{-- resources/views/admin/posts/index.blade.php --}}

@extends('adminlte::page')


@section('content')
<div class="container">

        <div class="card card-primary card-outline">
                <h3 class="list-group-item">tag: {{$tag->title}}</h3>
                <h4 class="list-group-item">Created: <a class="float-right">{{ $tag->created_at->format('j M Y, g:i a') }}
                    @unless ($tag->created_at->eq($tag->updated_at))
                        <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                    @endunless
                    </a></h4>
                    @forelse ($tag->posts as $post )
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                        <div class="card text-dark card-has-bg click-col" style="background-image:url('{{url('storage/'. $post->image)}}');">
                            <img class="card-img d-none" src="{{$post->image}}" alt="{{$post->title}}">
                            <div class="card-img-overlay d-flex flex-column">
                                    <div class="card-body">
                                        <small class="card-meta mb-2">{{$post->pivot->tags->title}}</small>
                                        <small style="float:right;margin-bottom: 1em;"><i class="far fa-clock"></i>{{$post->created_at->format('D m, Y')}}</small>
                                        <p class="card-title mt-0 " style="font-size: 13px;letter-spacing: "><a class="text-dark" href="{{route('admin.posts.show',$post->id)}}">
                                        </a></p>
                                        <p style="scroll-behavior: smooth;
                                        overflow: scroll;
                                        height: 100%;
                                        width: 100%;">{{$post->message }}</p>
                                    </div>
                            </div>
                        </div>
                    </div>
                    @empty
                                
                    @endforelse
        </div>
   
</div>
@stop



<style>

body{
background: #161616;
}
h1{
  color:#fff;
}
.lead{
  color:#aaa;
}

.card{
  border: none;
  transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
 overflow:hidden;
 border-radius:20px;
 min-height:450px;
   box-shadow: 0 0 12px 0 rgba(0,0,0,0.2);

 @media (max-width: 768px) {
  min-height:350px;
}

@media (max-width: 420px) {
  min-height:300px;
}

 &.card-has-bg{
 transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
  background-size:120%;
  background-repeat:no-repeat;
  background-position: center center;
  &:before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: inherit;
    -webkit-filter: grayscale(1);
  -moz-filter: grayscale(100%);
  -ms-filter: grayscale(100%);
  -o-filter: grayscale(100%);
  filter: grayscale(100%);}

  &:hover {
    transform: scale(0.98);
     box-shadow: 0 0 5px -2px rgba(0,0,0,0.3);
    background-size:130%;
     transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);

    .card-img-overlay {
      transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
      background: rgb(255,186,33);
     background: linear-gradient(0deg, rgba(255,186,33,0.5) 0%, rgba(255,186,33,1) 100%);
     }
  }
}
 .card-footer{
  background: none;
   border-top: none;
    .media{
     img{
       border:solid 3px rgba(255,255,255,0.3);
     }
   }
 }
  .card-title{font-weight:800}
 .card-meta{color:rgba(0,0,0,0.3);
  text-transform:uppercase;
   font-weight:500;
   letter-spacing:2px;}
 .card-body{ 
   transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
 

  }
 &:hover {
   .card-body{
     margin-top:30px;
     transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
   }
 cursor: pointer;
 transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
}
 .card-img-overlay {
  transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
 background: rgb(255,186,33);
background: linear-gradient(0deg, rgba(255,186,33,0.3785889355742297) 0%, rgba(255,186,33,1) 100%);
}
}
@media (max-width: 767px){
  
}

  </style>