<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Showtime>
 */
class ShowtimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $movieId = Movie::pluck('id')->toArray();
        return [
            'movie_id'=> $this->faker->randomElement($movieId),
            'date'=> $this->faker->dateTimeBetween($startDate = 'now' , $endDate = '+20 days')->format('Y_m_d'),
            'time'=> $this->faker->time()
        ];
    }
}
