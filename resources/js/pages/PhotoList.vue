<template>
  <div class="photo-list">
    <div class="grid">
      <Photo
        class="grid__item"
        v-for="photo in photos"
        :key="photo.id"
        :item="photo"
        @like="onLikeClick"
      />
    </div>
    <Pagination :current-page="currentPage" :last-page="lastPage" />
  </div>
</template>

<script>
import { OK } from '../util'
import Photo from '../components/Photo.vue'
import Pagination from '../components/Pagination.vue'

export default {
  components: {
    Photo,
    Pagination
  },
  data () {
    return {
      photos: [],
      currentPage: 0,
      lastPage: 0
    }
  },
  props: {
    page: {
      type: Number,
      required: false,
      default: 1
    }
  },
  methods: {
    async fetchPhotos () {
      // axiosとは非同期通信でデータを取得するためのモジュールです。Node.jsで書かれています。読み方はアクシオスです。
      // axiosはvueでgetやpostを行うときに使う
      // axiosはPromiseベースのHTTP ClientライブラリでGETやPOSTのHTTPリクエストを使ってサーバからデータの取得、データへのデータ送信を行うことができます。
      const response = await axios.get(`/api/photos?page=${this.page}`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.photos = response.data.data
      this.currentPage = response.data.current_page
      this.lastPage = response.data.last_page
    },
    // Photo.vueの以下の内容が引数に入る（Photo.vueでclickイベントによってlikeメソッドが呼ばれて,
    // そのlikeメソッドでemitによって親コンポーネントのlikeイベントを発動させることにより、onLikeClickメソッドが親で呼ばれる）
    // emitは親コンポーネントのイベントを呼ぶ、今回でいえば@like
      // like () {
      //   this.$emit('like', {
      //     id: this.item.id,
      //     liked: this.item.liked_by_user
      //   })
      // }
    onLikeClick ({ id, liked }) {
      if (! this.$store.getters['auth/check']) {
        alert('いいね機能を使うにはログインしてください。')
        return false
      }

      if (liked) {
        this.unlike(id)
      } else {
        this.like(id)
      }
    },
    async like (id) {
      const response = await axios.put(`/api/photos/${id}/like`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.photos = this.photos.map(photo => {
        if (photo.id === response.data.photo_id) {
          photo.likes_count += 1
          photo.liked_by_user = true
        }
        return photo
      })
    },
    async unlike (id) {
      const response = await axios.delete(`/api/photos/${id}/like`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.photos = this.photos.map(photo => {
        if (photo.id === response.data.photo_id) {
          photo.likes_count -= 1
          photo.liked_by_user = false
        }
        return photo
      })
    }
  },
  // watch（ウォッチャ）とは特定のdata(データ)やcomputed(算出プロパティ)の状態を監視して、何か変化があった時に予め登録しておいた処理を自動的に実行してくれる仕組みのことです。
  // 監視対象に変化が起きたら、登録した処理を自動で行ってくれる物という理解でOKです。
  watch: {
    $route: {
      async handler () {
        await this.fetchPhotos()
      },
      // コンポーネントが生成されたタイミングでも実行
      // immediate「すぐに、即座に」
      immediate: true
    }
  }
}
</script>