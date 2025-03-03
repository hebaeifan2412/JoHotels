@extends('admin.layout.app')

@section('heading', 'Reviews')

@section('main_content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Customer Reviews</h4>
                    </div>
                    <div class="card-body">
                        @if($reviews->isEmpty())
                            <p>No reviews found.</p>
                        @else
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Room Name</th>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviews as $review)
                                        <tr>
                                            <td>{{ $review->customer->name }}</td>
                                            <td>{{ $review->room->name }}</td>
                                            <td>{{ $review->rating }}</td>
                                            <td>{{ $review->review }}</td>
                                          
                                                <!-- Add buttons for actions (edit, delete) -->
                                                <td>
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.review_edit', $review->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                
                                                    <!-- Delete Button -->
                                                    <form action="{{ route('admin.review_delete', $review->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    
                                                </td>
                                                
                                       
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            {{ $reviews->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
