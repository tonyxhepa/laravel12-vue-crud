<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Post, PostForm, type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit Post',
        href: '/posts',
    },
];

const { currentPost } = defineProps<{
    currentPost: Post;
}>();

const form = useForm<PostForm>({
    title: currentPost.title,
    content: currentPost.content,
    image: null,
    _method: 'put',
});

const imagePreview = ref<string | null>(null);

const submit = () => {
    form.post(route('posts.update', currentPost.id));
};

const handleImageInput = (e: Event) => {
    const target = e.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

</script>

<template>
    <Head title="Update Post" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="min-w-md mx-auto p-6 mt-8 bg-white dark:bg-neutral-800 shadow-lg rounded-xl">
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6">
                        <div class="grid gap-2">
                            <Label for="title">Title</Label>
                            <Input
                                id="title"
                                type="text"
                                autofocus
                                :tabindex="1"
                                autocomplete="title"
                                v-model="form.title"
                                placeholder="First post"
                            />
                            <InputError :message="form.errors.title" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="title">Image</Label>
                            <Input
                                id="image"
                                type="file"
                                :tabindex="2"
                                @change="handleImageInput"
                            />
                          <div class="flex space-x-2">
                            <img v-if="currentPost.image" :src="currentPost.image" alt="" :class="[imagePreview ? 'opacity-30' : '', 'h-12 w-12 rounded object-cover']">
                            <img v-if="imagePreview" :src="imagePreview" alt="" class="h-12 w-12 rounded object-cover">
                          </div>
                            <InputError :message="form.errors.image" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="content">Content</Label>
                            <Textarea
                                id="content"
                                autofocus
                                :tabindex="3"
                                autocomplete="content"
                                v-model="form.content"
                                placeholder="First post"
                            />
                            <InputError :message="form.errors.content" />
                        </div>
                        <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                           Update
                        </Button>
                    </div>
        </form>
            </div>
        </div>
    </AppLayout>
</template>
