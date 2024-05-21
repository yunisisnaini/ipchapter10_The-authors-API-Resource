<?php

namespace Tests;

use Mockery as m;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Http\Response\FractalResponse;
use League\Fractal\Serializer\SerializerAbstract;

class FractalResponseTest extends TestCase
{
    /** @test **/
    public function it_can_be_initialized()
    {
        $manager = m::mock(Manager::class);
        $serializer = m::mock(SerializerAbstract::class);
        $request = m::mock(Request::class);

        $manager
            ->shouldReceive('setSerializer')
            ->with($serializer)
            ->once()
            ->andReturn($manager);

        $fractal = new FractalResponse($manager, $serializer, $request);
        $this->assertInstanceOf(FractalResponse::class, $fractal);
    }

    /** @test **/
    public function it_can_transform_an_item()
    {
        // Request
        $request = m::mock(Request::class);

        // Transformer
        $transformer = m::mock('League\Fractal\TransformerAbstract');

        // Scope
        $scope = m::mock('League\Fractal\Scope');
        $scope
            ->shouldReceive('toArray')
            ->once()
            ->andReturn(['foo' => 'bar']);

        // Serializer
        $serializer = m::mock('League\Fractal\Serializer\SerializerAbstract');

        $manager = m::mock('League\Fractal\Manager');
        $manager
            ->shouldReceive('setSerializer')
            ->with($serializer)
            ->once();

        $manager
            ->shouldReceive('createData')
            ->once()
            ->andReturn($scope);

        $subject = new FractalResponse($manager, $serializer, $request);
        $this->assertIsArray(
            $subject->item(['foo' => 'bar'], $transformer)
        );
    }

    /** @test **/
    public function it_can_transform_a_collection()
    {
        $data = [
            ['foo' => 'bar'],
            ['fizz' => 'buzz'],
        ];

        // Request
        $request = m::mock(Request::class);

        // Transformer
        $transformer = m::mock('League\Fractal\TransformerAbstract');

        // Scope
        $scope = m::mock('League\Fractal\Scope');
        $scope
            ->shouldReceive('toArray')
            ->once()
            ->andReturn($data);

        // Serializer
        $serializer = m::mock('League\Fractal\Serializer\SerializerAbstract');

        $manager = m::mock('League\Fractal\Manager');
        $manager
            ->shouldReceive('setSerializer')
            ->with($serializer)
            ->once();

        $manager
            ->shouldReceive('createData')
            ->once()
            ->andReturn($scope);

        $subject = new FractalResponse($manager, $serializer, $request);
        $this->assertIsArray(
            $subject->collection($data, $transformer)
        );
    }

    /** @test **/
    public function it_should_parse_passed_includes_when_passed()
    {
       $serializer = m::mock(SerializerAbstract::class);
       $manager = m::mock(Manager::class);
       $manager->shouldReceive('setSerializer')->with($serializer);
       $manager
           ->shouldReceive('parseIncludes')
           ->with('books');
       $request = m::mock(Request::class);
       $request->shouldNotReceive('query');
       $subject = new FractalResponse($manager, $serializer, $request);
       $subject->parseIncludes('books');
    }

   /** @test **/
   public function it_should_parse_request_query_includes_with_no_arguments()
   {
       $serializer = m::mock(SerializerAbstract::class);
       $manager = m::mock(Manager::class);

       $manager->shouldReceive('setSerializer')->once()->with($serializer);

       $manager->shouldReceive('parseIncludes')->once()->with('books');

       $request = m::mock(Request::class);
       $request
           ->shouldReceive('query')
           ->once()
           ->with('include', '')
           ->andReturn('books');

        $fractalResponse = new FractalResponse($manager, $serializer, $request);
        $fractalResponse->parseIncludes();
   }
}
