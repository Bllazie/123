<template>
  <Layout title="Серьги">
    <EarringsList />
  </Layout>
</template>

<script>
import Layout from '@/components/Layout/Layout';
import EarringsList from '@/components/EarringsList/EarringsList';


export default {
  name: 'Earrings',
  components: {
    Layout,
    EarringsList,
  }
}
</script>
