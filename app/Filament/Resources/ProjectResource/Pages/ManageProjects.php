<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Models\Project;
use App\Models\ProjectTaskCategory;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ManageRecords;

class ManageProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->using(function ($data) {
                if ($data['template'] && $data['template'] == 'website') {

                    $tasks = [
                        [
                            "name" => "Elaborar contrato",
                            "category" => "Onboarding/Setup Inicial",
                            "days" => 1,
                            "order" => 1
                        ],
                        [
                            "name" => "Enviar contrato p/ assinatura",
                            "category" => "Onboarding/Setup Inicial",
                            "days" => 1,
                            "order" => 2
                        ],
                        [
                            "name" => "Pagamento da Entrada",
                            "category" => "Onboarding/Setup Inicial",
                            "days" => 2,
                            "order" => 3
                        ],
                        [
                            "name" => "Agendar Discovery",
                            "category" => "Onboarding/Setup Inicial",
                            "days" => 2,
                            "order" => 4
                        ],
                        [
                            "name" => "Realizar Discovery",
                            "category" => "Onboarding/Setup Inicial",
                            "days" => 2,
                            "order" => 5
                        ],
                        [
                            "name" => "Receber Material e Manual de Marca",
                            "category" => "Onboarding/Setup Inicial",
                            "days" => 2,
                            "order" => 6
                        ],
                        [
                            "name" => "Processo de Discovery",
                            "category" => "Onboarding/Setup Inicial",
                            "days" => 5,
                            "order" => 7
                        ],
                        [
                            "name" => "Wireframe",
                            "category" => "Design",
                            "days" => 5,
                            "order" => 8
                        ],
                        [
                            "name" => "Ajustes/Feedback",
                            "category" => "Design",
                            "days" => 2,
                            "order" => 9
                        ],
                        [
                            "name" => "Design Desktop",
                            "category" => "Design",
                            "days" => 5,
                            "order" => 10
                        ],
                        [
                            "name" => "2 ajustes",
                            "category" => "Design",
                            "days" => 2,
                            "order" => 11
                        ],
                        [
                            "name" => "Desenvolvimento Versão Desktop",
                            "category" => "Desenvolvimento",
                            "days" => 7,
                            "order" => 12
                        ],
                        [
                            "name" => "Ajustes",
                            "category" => "Desenvolvimento",
                            "days" => 2,
                            "order" => 13
                        ],
                        [
                            "name" => "Responsividade Mobile",
                            "category" => "Desenvolvimento",
                            "days" => 2,
                            "order" => 14
                        ],
                        [
                            "name" => "2 ajustes",
                            "category" => "Desenvolvimento",
                            "days" => 2,
                            "order" => 15
                        ],
                        [
                            "name" => "Implementações",
                            "category" => "Desenvolvimento",
                            "days" => 5,
                            "order" => 16
                        ],
                        [
                            "name" => "Testes",
                            "category" => "Desenvolvimento",
                            "days" => 2,
                            "order" => 17
                        ],
                        [
                            "name" => "Setup DNS",
                            "category" => "Finalização",
                            "days" => 2,
                            "order" => 18
                        ],
                        [
                            "name" => "Setup Elementor/Framer",
                            "category" => "Finalização",
                            "days" => 1,
                            "order" => 19
                        ],
                        [
                            "name" => "Gerar Backup (Elementor)/Remix Link...",
                            "category" => "Finalização",
                            "days" => 0,
                            "order" => 20
                        ],
                        [
                            "name" => "Subir Backup no Website do Cliente",
                            "category" => "Finalização",
                            "days" => 0,
                            "order" => 21
                        ]
                    ];

                    $project = Project::create([
                        'name' => $data['name'],
                        'sale_id' => $data['sale_id'],
                        'business_name' => $data['business_name'],
                        'logo_url' => $data['logo_url'],
                    ]);

                    $onboardingCategory = ProjectTaskCategory::create([
                        'name' => 'Onboarding/Setup Inicial',
                        'project_id' => $project->id,
                        'color' => '#0000ff',
                        'order' => 1
                    ]);
                    $designCategory = ProjectTaskCategory::create([
                        'name' => 'Design',
                        'project_id' => $project->id,
                        'color' => '#FF007F',
                        'order' => 2
                    ]);
                    $developmentCategory = ProjectTaskCategory::create([
                        'name' => 'Desenvolvimento',
                        'project_id' => $project->id,
                        'color' => '#FFFF00',
                        'order' => 3
                    ]);
                    $finalizationCategory = ProjectTaskCategory::create([
                        'name' => 'Finalização',
                        'project_id' => $project->id,
                        'color' => '#00FFFF',
                        'order' => 4
                    ]);

                    foreach ($tasks as $task) {
                        if ($task['category'] == 'Onboarding/Setup Inicial') {
                            $project->project_tasks()->create([
                                'name' => $task['name'],
                                'project_task_category_id' => $onboardingCategory->id,
                                'days' => $task['days'],
                                'category' => 'Onboarding/Setup Inicial',
                                'order' => $task['order']
                            ]);
                        }

                        if ($task['category'] == 'Design') {
                            $project->project_tasks()->create([
                                'name' => $task['name'],
                                'project_task_category_id' => $designCategory->id,
                                'days' => $task['days'],

                                'category' => 'Design',
                                'order' => $task['order']
                            ]);
                        }

                        if ($task['category'] == 'Desenvolvimento') {
                            $project->project_tasks()->create([
                                'name' => $task['name'],
                                'project_task_category_id' => $developmentCategory->id,
                                'days' => $task['days'],
                                'category' => 'Desenvolvimento',
                                'order' => $task['order']
                            ]);
                        }

                        if ($task['category'] == 'Finalização') {
                            $project->project_tasks()->create([
                                'name' => $task['name'],
                                'project_task_category_id' => $finalizationCategory->id,
                                'days' => $task['days'],
                                'category' => 'Finalização',
                                'order' => $task['order']
                            ]);
                        }
                    }
                } else {
                    Project::create([
                        'name' => $data['name'],
                        'sale_id' => $data['sale_id'],
                        'business_name' => $data['business_name'],
                        'logo_url' => $data['logo_url'],
                    ]);
                }
            }),
        ];
    }
}
