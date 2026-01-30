<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaStoreRequest;
use App\Http\Requests\MediaUpdateRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::query();

        //Filtrado por tipo
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        //Filtrado por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        //Busqueda por nombre o ubicacion
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('location', 'like', "%{$request->search}%");
            });
        }

        $media = $query->paginate(10);
        return MediaResource::collection($media);
    }

    public function store(MediaStoreRequest $request): JsonResponse
    {
        $media = Media::create([
            'name' => $request->name,
            'type' => $request->type,
            'location' => $request->location,
            'dimensions' => $request->dimensions,
            'price_per_day' => $request->price_per_day,
            'status' => $request->status ?? 'active',
        ]);

        return (new MediaResource($media))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Media $media): MediaResource
    {
        return new MediaResource($media);
    }

    public function update(
        MediaUpdateRequest $request,
        Media $media
    ): MediaResource {
        $media->update($request->validated());
        return new MediaResource($media);
    }

    public function destroy(Media $media): JsonResponse
    {
        $media->update([
            'status' => 'inactive'
        ]);
        return response()->json([
            'message' => 'El medio ha sido desactivado correctamente.'
        ]);
    }
}
