<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FormController extends Controller
{
    // 1. Показ страницы с формой (GET)
    public function showForm()
    {
        return view('form');
    }

    // 2. Обработка отправки формы (POST), серверная валидация и сохранение в JSON
    public function submitForm(Request $request)
    {
        // Серверная валидация полей
        $validated = $request->validate([
            'name'    => 'required|string|min:2|max:50',
            'email'   => 'required|email|max:100',
            'message' => 'required|string|min:5|max:1000',
        ], [
            'name.required'    => 'Поле "Имя" обязательно для заполнения.',
            'name.min'         => 'Имя должно содержать не менее 2 символов.',
            'email.required'   => 'Поле "Email" обязательно для заполнения.',
            'email.email'      => 'Введите корректный email адрес.',
            'message.required' => 'Поле "Сообщение" обязательно для заполнения.',
            'message.min'      => 'Сообщение должно содержать не менее 5 символов.',
        ]);

        // Добавляем дату и время отправки
        $validated['created_at'] = now()->format('Y-m-d H:i:s');

        // Путь к папке хранения JSON: storage/app/submissions
        $storageDir = storage_path('app/submissions');
        if (!File::exists($storageDir)) {
            File::makeDirectory($storageDir, 0755, true);
        }

        // Генерируем уникальное имя файла
        $fileName = 'submission_' . uniqid() . '_' . time() . '.json';
        $filePath = $storageDir . DIRECTORY_SEPARATOR . $fileName;

        // Сохраняем данные в формате JSON (с поддержкой русских букв)
        File::put($filePath, json_encode($validated, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Возвращаем пользователя обратно с сообщением об успехе
        return redirect()->route('form.show')->with('success', "Данные успешно сохранены в файл: {$fileName}");
    }

    // 3. Вывод всех сохранённых данных в виде таблицы (GET)
    public function showSubmissions()
    {
        $storageDir = storage_path('app/submissions');
        $submissions = [];

        if (File::exists($storageDir)) {
            $files = File::files($storageDir);
            foreach ($files as $file) {
                if ($file->getExtension() === 'json') {
                    $content = json_decode(File::get($file->getPathname()), true);
                    if ($content) {
                        $content['file_name'] = $file->getFilename();
                        $submissions[] = $content;
                    }
                }
            }
        }

        return view('submissions', compact('submissions'));
    }
}