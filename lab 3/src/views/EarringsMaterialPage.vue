<template>
  <Layout title="Драгоценности">
    <EarringsMaterialList />
  </Layout>
</template>

<script>
import Layout from '@/components/Layout/Layout';

import EarringsMaterialList from "../components/EarringsMaterialList/EarringsMaterialList";


export default {
  name: 'Earrings',
  components: {
    Layout,
    EarringsMaterialList,
  }
}
</script>


