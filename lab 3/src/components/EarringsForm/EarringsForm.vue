<template>
  <div :class="$style.root">
    <div v-if="form.id" :class="$style.item">
      <div :class="$style.label">
        <label for="id">ID</label>
      </div>
      <input v-model="form.id" disabled :class="$style.input"  id="id" placeholder="id" type="text">
    </div>
    <div>
      <div :class="$style.item">
        <div :class="$style.label">
          <label for="photo">Фото</label>
        </div>
        <input type="file" id="photo" accept="image/*" @change="onFileChange">
      </div>
      <img v-if="form.img_path" :src="form.img_path" alt="Image" />
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="name">Имя</label>
      </div>
      <input v-model="form.name" :class="$style.input"  id="name" placeholder="Название" type="text">
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="surname">Стоимость</label>
      </div>
      <input v-model="form.cost" :class="$style.input" id="cost" placeholder="Стоимость" type="text">
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="patronymic">Описание</label>
      </div>
      <input v-model="form.description" :class="$style.input" id="description" placeholder="Описание" type="text">
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="id_material">Материал</label>
      </div>
      <select v-model="form.id_material" :class="$style.select" name="id_material" id="id_material">
        <option v-for="material in materialList" :key="material.id" :value="material.id">
          {{ material.material_name }}
        </option>
      </select>
    </div>
    <div :class="$style.item">
      <Btn @click="onClick" :disabled="!isValidForm" theme="info">Сохранить</Btn>
    </div>
  </div>
</template>

<script>
import { computed, reactive, onBeforeMount, watchEffect } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

import { selectItemById, fetchItems } from '@/store/earrings/selectors';
import { selectItems as selectMaterials, fetchMaterials } from '@/store/materials/selectors';
import Btn from '@/components/Btn/Btn';

export default {
  name: 'EarringsForm',
  props: {
    id: { type: String, default: '' },
  },
  components: {
    Btn,
  },
  setup(props, context) {
    const store = useStore();
    const router = useRouter();
    const materialList = computed(() => selectMaterials(store))
    const form = reactive({
      id: '',
      img_path: '',
      name: '',
      description: '' ,
      cost: '',
      id_material: '',
      //img_file:'',
    });

    onBeforeMount(() => {
      fetchItems(store);
      fetchMaterials(store);
    });

    watchEffect(() => {
      const earring = selectItemById(store, props.id);
      Object.keys(earring).forEach(key => {
        form[key] = earring[key]
      })
    });
    const onFileChange = (event) => {
      const file = event.target.files[0];
      if (file) {
        // form.img_path = file.name;
        form.img_path = file; // Сохраните файл в объекте формы
      }
    };

    return {
      materialList,
      form,
      isValidForm: computed(() =>  !!(form.name && form.description && form.cost && form.id_material)),
      onClick: () => {
        context.emit('submit', form);
        router.push({ name: 'Earrings' })
      },
      onFileChange,
    }
  },
}
</script>

<style module lang="scss">
.root {
  padding-top: 30px;
  max-width: 900px;

  .item {
    display: flex;
    align-items: center;

    & + .item {
      margin-top: 15px;
    }
  }

  .label {
    flex: 0 0 150px
  }

  .input {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
  }

  .select {
    display: block;
    width: 100%;
    padding: 0.375rem 2.25rem 0.375rem 0.75rem;
    -moz-padding-start: calc(0.75rem - 3px);
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    appearance: none;
  }
}
</style>
